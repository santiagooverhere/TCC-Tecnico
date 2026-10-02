import 'package:flutter/material.dart';
import '../db/database_helper.dart';
import '../models/post_model.dart';
import '../theme/app_theme.dart';

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
      backgroundColor: AppColors.primaryDark,
      appBar: AppBar(
        title: const Text("Novo item"),
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(20.0),
        child: Form(
          key: _formKey,
          child: Column(
            children: [
              TextFormField(
                controller: _tituloController,
                validator: (valor) =>
                    (valor == null || valor.trim().isEmpty) ? 'Informe o título' : null,
                style: const TextStyle(color: Colors.white),
                decoration: const InputDecoration(
                  labelText: 'Título',
                  prefixIcon: Icon(Icons.title),
                ),
              ),
              const SizedBox(height: 16),

              TextFormField(
                controller: _descricaoController,
                validator: (valor) =>
                    (valor == null || valor.trim().isEmpty) ? 'Informe a descrição' : null,
                style: const TextStyle(color: Colors.white),
                maxLines: 3,
                decoration: const InputDecoration(
                  labelText: 'Descrição',
                  prefixIcon: Icon(Icons.description),
                ),
              ),
              const SizedBox(height: 16),

              TextFormField(
                controller: _nomeItemController,
                validator: (valor) =>
                    (valor == null || valor.trim().isEmpty) ? 'Informe o nome do item' : null,
                style: const TextStyle(color: Colors.white),
                decoration: const InputDecoration(
                  labelText: 'Nome do item',
                  prefixIcon: Icon(Icons.category_outlined),
                ),
              ),
              const SizedBox(height: 28),

              SizedBox(
                width: double.infinity,
                child: ElevatedButton(
                  onPressed: _salvando ? null : _salvarItem,
                  child: _salvando
                      ? const SizedBox(
                          width: 20,
                          height: 20,
                          child: CircularProgressIndicator(color: Colors.white, strokeWidth: 2),
                        )
                      : const Text("Finalizar"),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
