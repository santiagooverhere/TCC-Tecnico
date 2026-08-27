import 'package:flutter/material.dart';
import '../db/database_helper.dart';
import '../models/post_model.dart';

class TelaCriar extends StatefulWidget{
  const TelaCriar({super.key});

  @override
  State<TelaCriar> createState() => _TelaCriarState();
}

class _TelaCriarState extends State<TelaCriar> {
  final _formKey = GlobalKey<FormState>();
  final _tituloController = TextEditingController();
  final _descricaoController = TextEditingController();
  final _nomeItemController = TextEditingController();

  bool _salvando = false;

  @override
  void dispose() {
    _tituloController.dispose();
    _descricaoController.dispose();
    _nomeItemController.dispose();
    super.dispose();
  }

  // Salva o item no banco local9
  Future<void> _salvarItem() async {
    if (!_formKey.currentState!.validate()) return;

    setState(() => _salvando = true);

    final agora = DateTime.now().toIso8601String();

    final novoPost = Post(
      titulo: _tituloController.text.trim(),
      descricao: _descricaoController.text.trim(),
      nomeItem: _nomeItemController.text.trim(),
      dataEncontrada: agora,
      createdAt: agora,
    );

    await DatabaseHelper.instance.inserirPost(novoPost);

    if (!mounted) return;

    setState(() => _salvando = false);

    _tituloController.clear();
    _descricaoController.clear();
    _nomeItemController.clear();

    ScaffoldMessenger.of(context).showSnackBar(
      const SnackBar(content: Text('Item salvo com sucesso!')),
    );

    Navigator.pushReplacementNamed(context, '/home');
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

      body: SingleChildScrollView(
        padding: const EdgeInsets.all(16.0),
        child: Form(
          key: _formKey,
          child: Column(
            children: [
              TextFormField(
                controller: _tituloController,
                validator: (valor) =>
                    (valor == null || valor.trim().isEmpty) ? 'Informe o título' : null,

                style: const TextStyle(color: Colors.white),
                decoration: InputDecoration(
                  labelText: 'Título',
                  labelStyle: const TextStyle(color: Colors.white),
                  prefixIcon: const Icon(Icons.title, color: Colors.white),

                  enabledBorder: OutlineInputBorder(
                    borderSide: const BorderSide(color: Colors.white),
                    borderRadius: BorderRadius.circular(10),
                  ),

                  focusedBorder: OutlineInputBorder(
                    borderSide: const BorderSide(color: Colors.white),
                    borderRadius: BorderRadius.circular(10),
                  ),
                ),
              ),

              const SizedBox(height: 15),

              TextFormField(
                controller: _descricaoController,
                validator: (valor) =>
                    (valor == null || valor.trim().isEmpty) ? 'Informe a descrição' : null,

                style: const TextStyle(color: Colors.white),
                decoration: InputDecoration(
                  labelText: 'Descrição',
                  labelStyle: const TextStyle(color: Colors.white),
                  prefixIcon: const Icon(Icons.description, color: Colors.white),

                  enabledBorder: OutlineInputBorder(
                    borderSide: const BorderSide(color: Colors.white),
                    borderRadius: BorderRadius.circular(10),
                  ),

                  focusedBorder: OutlineInputBorder(
                    borderSide: const BorderSide(color: Colors.white),
                    borderRadius: BorderRadius.circular(10),
                  ),
                ),
              ),

              const SizedBox(height: 15),

              TextFormField(
                controller: _nomeItemController,
                validator: (valor) =>
                    (valor == null || valor.trim().isEmpty) ? 'Informe o nome do item' : null,

                style: const TextStyle(color: Colors.white),
                decoration: InputDecoration(
                  labelText: 'Nome do item',
                  labelStyle: const TextStyle(color: Colors.white),
                  prefixIcon: const Icon(Icons.category, color: Colors.white),

                  enabledBorder: OutlineInputBorder(
                    borderSide: const BorderSide(color: Colors.white),
                    borderRadius: BorderRadius.circular(10),
                  ),

                  focusedBorder: OutlineInputBorder(
                    borderSide: const BorderSide(color: Colors.white),
                    borderRadius: BorderRadius.circular(10),
                  ),
                ),
              ),

              const SizedBox(height: 30),

              ElevatedButton(
                onPressed: _salvando ? null : _salvarItem,
                style: ElevatedButton.styleFrom(
                  backgroundColor: Colors.green[900],
                  foregroundColor: Colors.white,
                  padding: const EdgeInsets.symmetric(horizontal: 50, vertical: 15),
                ),
                child: _salvando
                    ? const SizedBox(
                        width: 20,
                        height: 20,
                        child: CircularProgressIndicator(color: Colors.white, strokeWidth: 2),
                      )
                    : const Text("Finalizar"),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
