import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import '../models/post_model.dart';
import '../models/comentario_model.dart';

class ApiException implements Exception {
  final String mensagem;
  ApiException(this.mensagem);

  @override
  String toString() => mensagem;
}

class ApiService {
  ApiService._internal();
  static final ApiService instance = ApiService._internal();

  static const String baseUrl = 'http://192.168.0.101:8000/api';

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
  }

  Future<bool> get estaLogado async {
    await _carregarToken();
    return _token != null;
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
  }) async {
    final uri = Uri.parse('$baseUrl/posts');
    final request = http.MultipartRequest('POST', uri);
    request.headers.addAll(await _headers());
    request.fields['nome_item'] = nomeItem;
    request.fields['descricao'] = descricao;
    request.files.add(await http.MultipartFile.fromPath('imagem', caminhoImagem));

    final streamed = await request.send();
    final response = await http.Response.fromStream(streamed);

    if (response.statusCode != 200 && response.statusCode != 201) {
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

    if (response.statusCode != 200) {
      throw ApiException(_extrairErro(response));
    }
  }
}
