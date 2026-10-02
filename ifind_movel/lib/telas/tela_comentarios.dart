import 'package:flutter/material.dart';
import '../db/database_helper.dart';
import '../models/post_model.dart';
import '../models/comentario_model.dart';
import '../theme/app_theme.dart';

class TelaComentarios extends StatefulWidget {
  final Post post;

  const TelaComentarios({super.key, required this.post});

  @override
  State<TelaComentarios> createState() => _TelaComentariosState();
}

class _TelaComentariosState extends State<TelaComentarios> {
  late Future<List<Comentario>> _comentariosFuture;
  final _nomeController = TextEditingController();
  final _textoController = TextEditingController();
  bool _enviando = false;

  static const int _usersIdTemporario = 1;

  @override
  void initState() {
    super.initState();
    _carregarComentarios();
  }

  void _carregarComentarios() {
    _comentariosFuture = DatabaseHelper.instance.listarComentariosPorPost(widget.post.id!);
  }

  @override
  void dispose() {
    _nomeController.dispose();
    _textoController.dispose();
    super.dispose();
  }

  Future<void> _enviarComentario() async {
    if (_nomeController.text.trim().isEmpty || _textoController.text.trim().isEmpty) {
      return;
    }

    setState(() => _enviando = true);

    final comentario = Comentario(
      usersId: _usersIdTemporario,
      postId: widget.post.id!,
      nameUser: _nomeController.text.trim(),
      texto: _textoController.text.trim(),
      createdAt: DateTime.now().toIso8601String(),
    );

    await DatabaseHelper.instance.inserirComentario(comentario);

    if (!mounted) return;

    _textoController.clear();
    setState(() {
      _enviando = false;
      _carregarComentarios();
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text(widget.post.nomeItem),
      ),
      body: Column(
        children: [
          Expanded(
            child: FutureBuilder<List<Comentario>>(
              future: _comentariosFuture,
              builder: (context, snapshot) {
                if (snapshot.connectionState == ConnectionState.waiting) {
                  return const Center(child: CircularProgressIndicator());
                }

                final comentarios = snapshot.data ?? [];

                if (comentarios.isEmpty) {
                  return const Center(
                    child: Padding(
                      padding: EdgeInsets.all(24.0),
                      child: Text(
                        'Nenhum comentário ainda.\nSeja o primeiro a comentar.',
                        textAlign: TextAlign.center,
                        style: TextStyle(color: AppColors.textMuted),
                      ),
                    ),
                  );
                }

                return ListView.builder(
                  padding: const EdgeInsets.all(12.0),
                  itemCount: comentarios.length,
                  itemBuilder: (context, index) {
                    final comentario = comentarios[index];
                    return Card(
                      child: Padding(
                        padding: const EdgeInsets.all(12.0),
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Text(
                              comentario.nameUser,
                              style: const TextStyle(fontWeight: FontWeight.bold, color: AppColors.primaryDark),
                            ),
                            const SizedBox(height: 4),
                            Text(comentario.texto),
                          ],
                        ),
                      ),
                    );
                  },
                );
              },
            ),
          ),

          SafeArea(
            top: false,
            child: Container(
              padding: const EdgeInsets.all(12.0),
              decoration: const BoxDecoration(
                color: AppColors.card,
                border: Border(top: BorderSide(color: Color(0xFFE0E0E0))),
              ),
              child: Column(
                children: [
                  TextField(
                    controller: _nomeController,
                    decoration: const InputDecoration(
                      labelText: 'Seu nome',
                      isDense: true,
                      filled: false,
                      border: OutlineInputBorder(),
                      enabledBorder: OutlineInputBorder(),
                    ),
                  ),
                  const SizedBox(height: 8),
                  Row(
                    children: [
                      Expanded(
                        child: TextField(
                          controller: _textoController,
                          decoration: const InputDecoration(
                            labelText: 'Escreva um comentário...',
                            isDense: true,
                            filled: false,
                            border: OutlineInputBorder(),
                            enabledBorder: OutlineInputBorder(),
                          ),
                        ),
                      ),
                      const SizedBox(width: 8),
                      IconButton.filled(
                        onPressed: _enviando ? null : _enviarComentario,
                        icon: _enviando
                            ? const SizedBox(
                                width: 18,
                                height: 18,
                                child: CircularProgressIndicator(strokeWidth: 2, color: Colors.white),
                              )
                            : const Icon(Icons.send),
                      ),
                    ],
                  ),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }
}
