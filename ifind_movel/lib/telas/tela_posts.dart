import 'package:flutter/material.dart';
import '../db/database_helper.dart';
import '../models/post_model.dart';

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
      backgroundColor: Colors.green[800],
      appBar: AppBar(
        backgroundColor: Colors.green[900],
        title: const Text("Achados e Perdidos", style: TextStyle(color: Colors.white)),
        centerTitle: true,
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
                  style: const TextStyle(color: Colors.white),
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
                        style: TextStyle(color: Colors.white),
                      ),
                    ),
                  ),
                ),
              );
            }

            return ListView.builder(
              padding: const EdgeInsets.all(8.0),
              itemCount: posts.length,
              itemBuilder: (context, index) {
                final post = posts[index];
                final devolvido = post.dataDevolvida != null;

                return Card(
                  elevation: 3.0,
                  color: Colors.white,
                  child: ListTile(
                    title: Text(post.titulo, style: const TextStyle(fontWeight: FontWeight.bold)),
                    subtitle: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text('${post.nomeItem} — ${post.descricao}'),
                        Text(
                          devolvido ? 'Devolvido' : 'Aguardando devolução',
                          style: TextStyle(
                            color: devolvido ? Colors.green[800] : Colors.orange[800],
                            fontWeight: FontWeight.bold,
                            fontSize: 12,
                          ),
                        ),
                      ],
                    ),

                    leading: Container(
                      width: 50,
                      height: 50,
                      color: Colors.grey[300],
                      child: const Icon(Icons.camera_alt, color: Colors.grey),
                    ),

                    trailing: Row(
                      mainAxisSize: MainAxisSize.min,
                      children: [
                        if (!devolvido)
                          IconButton(
                            icon: Icon(Icons.check_circle_outline, color: Colors.green[800]),
                            tooltip: 'Marcar como devolvido',
                            onPressed: () async {
                              if (post.id != null) {
                                await DatabaseHelper.instance.marcarComoDevolvido(post.id!);
                                await _recarregar();
                              }
                            },
                          ),
                        IconButton(
                          icon: const Icon(Icons.delete, color: Colors.red),
                          onPressed: () async {
                            if (post.id != null) {
                              await DatabaseHelper.instance.excluirPost(post.id!);
                              await _recarregar();
                            }
                          },
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
