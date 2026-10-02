import 'package:flutter/material.dart';
import '../db/database_helper.dart';
import '../models/post_model.dart';
import '../theme/app_theme.dart';
import 'tela_comentarios.dart';

class TelaPosts extends StatefulWidget{
  const TelaPosts({super.key});

  @override
  State<TelaPosts> createState() => _TelaPostsState();
}

class _TelaPostsState extends State<TelaPosts> {
  late Future<List<Post>> _postsFuture;

  @override
  void initState() {
    super.initState();
    _carregarPosts();
  }

  void _carregarPosts() {
    _postsFuture = DatabaseHelper.instance.listarPosts();
  }

  Future<void> _recarregar() async {
    setState(() {
      _carregarPosts();
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text("Achados e Perdidos"),
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
              return Center(
                child: Text(
                  'Erro ao carregar itens: ${snapshot.error}',
                  style: const TextStyle(color: AppColors.textMuted),
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
              padding: const EdgeInsets.all(12.0),
              itemCount: posts.length,
              itemBuilder: (context, index) {
                final post = posts[index];
                final devolvido = post.dataDevolvida != null;

                return Card(
                  child: Padding(
                    padding: const EdgeInsets.all(12.0),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Row(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Container(
                              width: 52,
                              height: 52,
                              decoration: BoxDecoration(
                                color: AppColors.background,
                                borderRadius: BorderRadius.circular(10),
                              ),
                              child: const Icon(Icons.image_outlined, color: AppColors.textMuted),
                            ),
                            const SizedBox(width: 12),
                            Expanded(
                              child: Column(
                                crossAxisAlignment: CrossAxisAlignment.start,
                                children: [
                                  Text(
                                    post.titulo,
                                    style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 15),
                                  ),
                                  const SizedBox(height: 2),
                                  Text(
                                    '${post.nomeItem} — ${post.descricao}',
                                    maxLines: 2,
                                    overflow: TextOverflow.ellipsis,
                                    style: const TextStyle(color: AppColors.textMuted, fontSize: 13),
                                  ),
                                  const SizedBox(height: 6),
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
                          ],
                        ),
                        const Divider(height: 20),
                        Row(
                          mainAxisAlignment: MainAxisAlignment.end,
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
                            if (!devolvido)
                              IconButton(
                                icon: const Icon(Icons.check_circle_outline, color: AppColors.primary),
                                tooltip: 'Marcar como devolvido',
                                onPressed: () async {
                                  if (post.id != null) {
                                    await DatabaseHelper.instance.marcarComoDevolvido(post.id!);
                                    await _recarregar();
                                  }
                                },
                              ),
                            IconButton(
                              icon: const Icon(Icons.delete_outline, color: AppColors.danger),
                              onPressed: () async {
                                if (post.id != null) {
                                  await DatabaseHelper.instance.excluirPost(post.id!);
                                  await _recarregar();
                                }
                              },
                            ),
                          ],
                        ),
                      ],
                    ),
                  ),
                );
              },
            );
          },
        ),
      ),
    );
  }
}
