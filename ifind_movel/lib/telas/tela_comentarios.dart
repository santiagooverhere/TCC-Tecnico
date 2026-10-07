import 'package:flutter/material.dart';
import '../models/post_model.dart';
import '../models/comentario_model.dart';
import '../services/api_service.dart';
import '../theme/app_theme.dart';

class TelaComentarios extends StatefulWidget {
  final Post post;

  const TelaComentarios({super.key, required this.post});

  @override
  State<TelaComentarios> createState() => _TelaComentariosState();
}

class _TelaComentariosState extends State<TelaComentarios> {
  late Future<List<Comentario>> _comentariosFuture;
  final _textoController = TextEditingController();
  bool _enviando = false;

  @override
  void initState() {
    super.initState();
    _carregarComentarios();
  }

  void _carregarComentarios() {
    _comentariosFuture = ApiService.instance.listarComentarios(widget.post.id!);
  }

  @override
  void dispose() {
    _textoController.dispose();
    super.dispose();
  }

  Future<void> _enviarComentario() async {
    if (_textoController.text.trim().isEmpty) return;

    setState(() => _enviando = true);

    try {
      await ApiService.instance.criarComentario(widget.post.id!, _textoController.text.trim());
      if (!mounted) return;
      _textoController.clear();
      setState(() => _carregarComentarios());
    } catch (e) {
      if (!mounted) return;
      ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text(e.toString())));
    } finally {
      if (mounted) setState(() => _enviando = false);
    }
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

                if (snapshot.hasError) {
                  return Center(
                    child: Padding(
                      padding: const EdgeInsets.all(24.0),
                      child: Text(
                        'Erro ao carregar comentários:\n${snapshot.error}',
                        textAlign: TextAlign.center,
                        style: const TextStyle(color: AppColors.textMuted),
                      ),
                    ),
                  );
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
              child: Row(
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
            ),
          ),
        ],
      ),
    );
  }
}
