import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import '../models/post_model.dart';
import '../models/comentario_model.dart';
import 'navegacao.dart';

class ApiException implements Exception {
  final String mensagem;
  ApiException(this.mensagem);

  @override
  String toString() => mensagem;
}

class UsuarioLogado {
  final int? id;
  final bool admin;

  UsuarioLogado({this.id, this.admin = false});
}

class ApiService {
  ApiService._internal();
  static final ApiService instance = ApiService._internal();

  static const String baseUrl = 'https://ifind.wasmer.app/api';
  static String get siteUrl => baseUrl.replaceFirst(RegExp(r'/api/?$'), '');

  String? _token;

  Future<void> _carregarToken() async {
    if (_token != null) return;
    final prefs = await SharedPreferences.getInstance();
    _token = prefs.getString('auth_token');
  }

  Future<void> _salvarToken(String token) async {
    _token = token;
    final prefs = await SharedPreferences.getInstance();
    await prefs.setString('auth_token', token);
  }

  Future<void> _limparToken() async {
    _token = null;
    final prefs = await SharedPreferences.getInstance();
    await prefs.remove('auth_token');
    await prefs.remove('user_id');
    await prefs.remove('user_admin');
  }

  Future<void> _salvarUsuario(Map<String, dynamic> usuario) async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.setInt('user_id', usuario['id'] as int);
    await prefs.setBool('user_admin', usuario['is_admin'] == true);
  }

  Future<UsuarioLogado> usuarioLogado() async {
    final prefs = await SharedPreferences.getInstance();
    final id = prefs.getInt('user_id');
    if (id != null) {
      return UsuarioLogado(id: id, admin: prefs.getBool('user_admin') ?? false);
    }

    await _carregarToken();
    if (_token == null) return UsuarioLogado();

    try {
      final response = await http.get(Uri.parse('$baseUrl/me'), headers: await _headers());
      if (response.statusCode != 200) return UsuarioLogado();
      final usuario = jsonDecode(response.body) as Map<String, dynamic>;
      await _salvarUsuario(usuario);
      return UsuarioLogado(id: usuario['id'] as int, admin: usuario['is_admin'] == true);
    } catch (_) {
      return UsuarioLogado();
    }
  }

  Future<bool> get estaLogado async {
    await _carregarToken();
    return _token != null;
  }

  Future<bool> sessaoValida() async {
    await _carregarToken();
    if (_token == null) return false;

    try {
      final response = await http
          .get(Uri.parse('$baseUrl/me'), headers: await _headers())
          .timeout(const Duration(seconds: 15));
      if (response.statusCode == 401) {
        await _limparToken();
        return false;
      }
      return true;
    } catch (_) {
      return true;
    }
  }

  Future<void> _tratarNaoAutorizado(http.Response response) async {
    if (response.statusCode != 401) return;
    await _limparToken();
    navigatorKey.currentState?.pushNamedAndRemoveUntil('/login', (route) => false);
    throw ApiException('Sua sessão expirou. Entre novamente.');
  }

  Future<Map<String, String>> _headers({bool comAuth = true}) async {
    final headers = {'Accept': 'application/json'};
    if (comAuth) {
      await _carregarToken();
      if (_token != null) headers['Authorization'] = 'Bearer $_token';
    }
    return headers;
  }

  String _extrairErro(http.Response response) {
    try {
      final body = jsonDecode(response.body) as Map<String, dynamic>;
      if (body['errors'] != null) {
        final errors = body['errors'] as Map<String, dynamic>;
        final primeiro = errors.values.first;
        if (primeiro is List && primeiro.isNotEmpty) return primeiro.first.toString();
      }
      if (body['message'] != null) return body['message'].toString();
    } catch (_) {

    }
    return 'Erro ao comunicar com o servidor (${response.statusCode}).';
  }

  // ---------------- Autenticação ----------------

  Future<void> login(String email, String senha) async {
    final response = await http.post(
      Uri.parse('$baseUrl/login'),
      headers: await _headers(comAuth: false),
      body: {'email': email, 'password': senha},
    );

    if (response.statusCode != 200) {
      throw ApiException(_extrairErro(response));
    }

    final body = jsonDecode(response.body) as Map<String, dynamic>;
    await _salvarToken(body['token'] as String);
    final usuario = body['user'];
    if (usuario is Map<String, dynamic>) await _salvarUsuario(usuario);
  }

  Future<void> logout() async {
    try {
      await http.post(Uri.parse('$baseUrl/logout'), headers: await _headers());
    } catch (_) {

    }
    await _limparToken();
  }

  // ---------------- Posts ----------------

  Future<List<Post>> listarPosts({String? busca, String? tipo}) async {
    final params = <String, String>{};
    if (busca != null && busca.isNotEmpty) params['busca'] = busca;
    if (tipo != null && tipo.isNotEmpty) params['tipo'] = tipo;

    final uri = Uri.parse('$baseUrl/posts').replace(queryParameters: params.isEmpty ? null : params);
    final response = await http.get(uri, headers: await _headers());

    await _tratarNaoAutorizado(response);
    if (response.statusCode != 200) {
      throw ApiException(_extrairErro(response));
    }

    final body = jsonDecode(response.body) as Map<String, dynamic>;
    final lista = body['data'] as List;
    return lista.map((item) => Post.fromJson(item as Map<String, dynamic>)).toList();
  }

  Future<Post> criarPost({
    required String nomeItem,
    required String descricao,
    required String caminhoImagem,
    required DateTime dataEncontrada,
  }) async {
    final uri = Uri.parse('$baseUrl/posts');
    final request = http.MultipartRequest('POST', uri);
    request.headers.addAll(await _headers());
    request.fields['nome_item'] = nomeItem;
    request.fields['descricao'] = descricao;
    request.fields['data_encontrada'] = dataEncontrada.toUtc().toIso8601String();
    request.files.add(await http.MultipartFile.fromPath('imagem', caminhoImagem));

    final streamed = await request.send();
    final response = await http.Response.fromStream(streamed);

    await _tratarNaoAutorizado(response);
    if (response.statusCode != 200 && response.statusCode != 201) {
      throw ApiException(_extrairErro(response));
    }

    final body = jsonDecode(response.body) as Map<String, dynamic>;
    return Post.fromJson(body['data'] as Map<String, dynamic>);
  }

  Future<Post> editarPost(
    int postId, {
    required String nomeItem,
    required String descricao,
    required DateTime dataEncontrada,
    String? caminhoImagem,
  }) async {
    final request = http.MultipartRequest('POST', Uri.parse('$baseUrl/posts/$postId'));
    request.headers.addAll(await _headers());
    request.fields['nome_item'] = nomeItem;
    request.fields['descricao'] = descricao;
    request.fields['data_encontrada'] = dataEncontrada.toUtc().toIso8601String();
    if (caminhoImagem != null) {
      request.files.add(await http.MultipartFile.fromPath('imagem', caminhoImagem));
    }

    final streamed = await request.send();
    final response = await http.Response.fromStream(streamed);

    await _tratarNaoAutorizado(response);
    if (response.statusCode != 200) {
      throw ApiException(_extrairErro(response));
    }

    final body = jsonDecode(response.body) as Map<String, dynamic>;
    return Post.fromJson(body['data'] as Map<String, dynamic>);
  }

  Future<void> marcarComoDevolvido(int postId) async {
    final response = await http.patch(
      Uri.parse('$baseUrl/posts/$postId/resolver'),
      headers: await _headers(),
    );

    await _tratarNaoAutorizado(response);
    if (response.statusCode != 200) {
      throw ApiException(_extrairErro(response));
    }
  }

  // ---------------- Comentários ----------------

  Future<List<Comentario>> listarComentarios(int postId) async {
    final response = await http.get(
      Uri.parse('$baseUrl/posts/$postId/comentarios'),
      headers: await _headers(),
    );

    await _tratarNaoAutorizado(response);
    if (response.statusCode != 200) {
      throw ApiException(_extrairErro(response));
    }

    final body = jsonDecode(response.body) as Map<String, dynamic>;
    final lista = body['data'] as List;
    return lista.map((item) => Comentario.fromJson(item as Map<String, dynamic>)).toList();
  }

  Future<Comentario> criarComentario(int postId, String texto) async {
    final response = await http.post(
      Uri.parse('$baseUrl/posts/$postId/comentarios'),
      headers: await _headers(),
      body: {'texto': texto},
    );

    await _tratarNaoAutorizado(response);
    if (response.statusCode != 200 && response.statusCode != 201) {
      throw ApiException(_extrairErro(response));
    }

    final body = jsonDecode(response.body) as Map<String, dynamic>;
    return Comentario.fromJson(body['data'] as Map<String, dynamic>);
  }

  Future<void> excluirComentario(int comentarioId) async {
    final response = await http.delete(
      Uri.parse('$baseUrl/comentarios/$comentarioId'),
      headers: await _headers(),
    );

    await _tratarNaoAutorizado(response);
    if (response.statusCode != 200) {
      throw ApiException(_extrairErro(response));
    }
  }
}
