import 'package:flutter/material.dart';
import '../models/post_model.dart';
import '../services/api_service.dart';
import '../theme/app_theme.dart';
import '../utils/contato.dart';
import '../utils/formatadores.dart';
import 'tela_comentarios.dart';
import 'tela_editar.dart';

class TelaPosts extends StatefulWidget{
  const TelaPosts({super.key});

  @override
  State<TelaPosts> createState() => _TelaPostsState();
}

class _TelaPostsState extends State<TelaPosts> {
  late Future<List<Post>> _postsFuture;
  int? _meuId;
  bool _admin = false;

  @override
  void initState() {
    super.initState();
    _carregarPosts();
    _carregarUsuario();
  }

  void _carregarPosts() {
    _postsFuture = ApiService.instance.listarPosts();
  }

  Future<void> _carregarUsuario() async {
    final usuario = await ApiService.instance.usuarioLogado();
    if (!mounted) return;
    setState(() {
      _meuId = usuario.id;
      _admin = usuario.admin;
    });
  }

  Future<void> _recarregar() async {
    setState(() {
      _carregarPosts();
    });
  }

  void _mostrarMensagem(String texto) {
    ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text(texto)));
  }

  void _ampliarImagem(String url) {
    showDialog<void>(
      context: context,
      builder: (dialogContext) => Dialog(
        backgroundColor: Colors.black,
        insetPadding: EdgeInsets.zero,
        child: Stack(
          children: [
            InteractiveViewer(
              child: Center(child: Image.network(url, fit: BoxFit.contain)),
            ),
            Positioned(
              top: 8,
              right: 8,
              child: IconButton(
                icon: const Icon(Icons.close, color: Colors.white),
                onPressed: () => Navigator.pop(dialogContext),
              ),
            ),
          ],
        ),
      ),
    );
  }

  Future<void> _editar(Post post, bool devolvido) async {
    if (devolvido && !_admin) {
      _mostrarMensagem('Posts já devolvidos não podem ser editados.');
      return;
    }

    final atualizou = await Navigator.push<bool>(
      context,
      MaterialPageRoute(builder: (_) => TelaEditar(post: post)),
    );

    if (atualizou == true) await _recarregar();
  }

  Future<void> _contatar(Post post) async {
    final email = post.autor?.email;
    if (email == null) {
      _mostrarMensagem('Não foi possível encontrar o contato do autor.');
      return;
    }

    final abriu = await abrirEmailContato(
      email: email,
      assunto: 'IFIND - Sobre o item: ${post.nomeItem}',
      mensagem: 'Olá! Vi seu post sobre "${post.nomeItem}" no IFIND e gostaria de falar sobre isso.',
    );

    if (!abriu && mounted) {
      _mostrarMensagem('Não foi possível abrir o e-mail.');
    }
  }

  Widget _imagemDoPost(Post post) {
    return GestureDetector(
      onTap: () => _ampliarImagem(post.imagemUrl),
      child: AspectRatio(
        aspectRatio: 1,
        child: Image.network(
          post.imagemUrl,
          width: double.infinity,
          fit: BoxFit.cover,
          loadingBuilder: (context, child, progresso) {
            if (progresso == null) return child;
            return Container(
              color: AppColors.background,
              child: const Center(child: CircularProgressIndicator()),
            );
          },
          errorBuilder: (context, error, stack) => Container(
            color: AppColors.background,
            child: const Center(
              child: Icon(Icons.image_outlined, size: 48, color: AppColors.textMuted),
            ),
          ),
        ),
      ),
    );
  }

  Widget _cartaoDoPost(Post post) {
    final devolvido = post.dataDevolvida != null;
    final ehMeu = _meuId != null && post.usersId == _meuId;
    final podeAgir = ehMeu || _admin;
    final nomeAutor = post.autor?.name ?? 'Usuário';
    final dataEncontrada = formatarDataHoraIso(post.dataEncontrada);

    return Card(
      clipBehavior: Clip.antiAlias,
      child: InkWell(
        onLongPress: podeAgir ? () => _editar(post, devolvido) : null,
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Padding(
              padding: const EdgeInsets.fromLTRB(12, 12, 12, 10),
              child: Row(
                children: [
                  CircleAvatar(
                    backgroundColor: AppColors.primary,
                    child: Text(
                      nomeAutor.isNotEmpty ? nomeAutor[0].toUpperCase() : '?',
                      style: const TextStyle(color: Colors.white, fontWeight: FontWeight.bold),
                    ),
                  ),
                  const SizedBox(width: 10),
                  Expanded(
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          ehMeu ? '$nomeAutor (você)' : nomeAutor,
                          maxLines: 1,
                          overflow: TextOverflow.ellipsis,
                          style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 14),
                        ),
                        if (dataEncontrada.isNotEmpty)
                          Text(
                            'Encontrado em $dataEncontrada',
                            style: const TextStyle(color: AppColors.textMuted, fontSize: 11),
                          ),
                      ],
                    ),
                  ),
                  Container(
                    padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 3),
                    decoration: BoxDecoration(
                      color: devolvido
                          ? AppColors.primary.withValues(alpha: 0.12)
                          : AppColors.warning.withValues(alpha: 0.12),
                      borderRadius: BorderRadius.circular(20),
                    ),
                    child: Text(
                      devolvido ? 'Devolvido' : 'Aguardando devolução',
                      style: TextStyle(
                        color: devolvido ? AppColors.primary : AppColors.warning,
                        fontWeight: FontWeight.w600,
                        fontSize: 11,
                      ),
                    ),
                  ),
                ],
              ),
            ),

            _imagemDoPost(post),

            Padding(
              padding: const EdgeInsets.fromLTRB(12, 12, 12, 4),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    post.nomeItem,
                    style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 17),
                  ),
                  if ((post.descricao ?? '').isNotEmpty) ...[
                    const SizedBox(height: 4),
                    Text(
                      post.descricao!,
                      style: const TextStyle(color: AppColors.textMuted, fontSize: 14),
                    ),
                  ],
                ],
              ),
            ),

            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 4, vertical: 2),
              child: Wrap(
                crossAxisAlignment: WrapCrossAlignment.center,
                children: [
                  TextButton.icon(
                    onPressed: () {
                      Navigator.push(
                        context,
                        MaterialPageRoute(builder: (_) => TelaComentarios(post: post)),
                      );
                    },
                    icon: const Icon(Icons.chat_bubble_outline, size: 18),
                    label: const Text('Comentários'),
                  ),
                  if (!ehMeu)
                    TextButton.icon(
                      onPressed: () => _contatar(post),
                      icon: const Icon(Icons.mail_outline, size: 18),
                      label: const Text('Contato'),
                    ),
                  if (!devolvido && podeAgir)
                    TextButton.icon(
                      onPressed: () async {
                        if (post.id == null) return;
                        try {
                          await ApiService.instance.marcarComoDevolvido(post.id!);
                          await _recarregar();
                        } catch (e) {
                          if (!mounted) return;
                          _mostrarMensagem(e.toString());
                        }
                      },
                      icon: const Icon(Icons.check_circle_outline, size: 18),
                      label: const Text('Devolvido'),
                    ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text("Achados e Perdidos"),
        actions: [
          IconButton(
            icon: const Icon(Icons.logout),
            tooltip: 'Sair',
            onPressed: () async {
              await ApiService.instance.logout();
              if (!context.mounted) return;
              Navigator.pushNamedAndRemoveUntil(context, '/login', (route) => false);
            },
          ),
        ],
      ),
      body: RefreshIndicator(
        onRefresh: _recarregar,
        child: FutureBuilder<List<Post>>(
          future: _postsFuture,
          builder: (context, snapshot) {
            if (snapshot.connectionState == ConnectionState.waiting) {
              return const Center(child: CircularProgressIndicator());
            }

            if (snapshot.hasError) {
              return LayoutBuilder(
                builder: (context, constraints) => SingleChildScrollView(
                  physics: const AlwaysScrollableScrollPhysics(),
                  child: ConstrainedBox(
                    constraints: BoxConstraints(minHeight: constraints.maxHeight),
                    child: Center(
                      child: Padding(
                        padding: const EdgeInsets.all(24.0),
                        child: Text(
                          'Erro ao carregar itens:\n${snapshot.error}',
                          textAlign: TextAlign.center,
                          style: const TextStyle(color: AppColors.textMuted),
                        ),
                      ),
                    ),
                  ),
                ),
              );
            }

            final posts = snapshot.data ?? [];

            if (posts.isEmpty) {
              return LayoutBuilder(
                builder: (context, constraints) => SingleChildScrollView(
                  physics: const AlwaysScrollableScrollPhysics(),
                  child: ConstrainedBox(
                    constraints: BoxConstraints(minHeight: constraints.maxHeight),
                    child: const Center(
                      child: Text(
                        'Nenhum item cadastrado ainda.\nToque em "Criar" para adicionar.',
                        textAlign: TextAlign.center,
                        style: TextStyle(color: AppColors.textMuted),
                      ),
                    ),
                  ),
                ),
              );
            }

            return ListView.builder(
              physics: const AlwaysScrollableScrollPhysics(),
              padding: const EdgeInsets.all(12.0),
              itemCount: posts.length,
              itemBuilder: (context, index) => _cartaoDoPost(posts[index]),
            );
          },
        ),
      ),
    );
  }
}
