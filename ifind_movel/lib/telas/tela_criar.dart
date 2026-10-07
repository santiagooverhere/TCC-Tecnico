import 'dart:io';
import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';
import '../services/api_service.dart';
import '../theme/app_theme.dart';

class TelaCriar extends StatefulWidget{
  const TelaCriar({super.key});

  @override
  State<TelaCriar> createState() => _TelaCriarState();
}

class _TelaCriarState extends State<TelaCriar> {
  final _formKey = GlobalKey<FormState>();
  final _descricaoController = TextEditingController();
  final _nomeItemController = TextEditingController();

  XFile? _imagemSelecionada;
  bool _salvando = false;
  String? _erro;

  @override
  void dispose() {
    _descricaoController.dispose();
    _nomeItemController.dispose();
    super.dispose();
  }

  Future<void> _escolherImagem() async {
    final imagem = await ImagePicker().pickImage(source: ImageSource.gallery, imageQuality: 85);
    if (imagem != null) {
      setState(() => _imagemSelecionada = imagem);
    }
  }

  Future<void> _salvarItem() async {
    if (!_formKey.currentState!.validate()) return;

    if (_imagemSelecionada == null) {
      setState(() => _erro = 'Selecione uma imagem para o item.');
      return;
    }

    setState(() {
      _salvando = true;
      _erro = null;
    });

    try {
      await ApiService.instance.criarPost(
        nomeItem: _nomeItemController.text.trim(),
        descricao: _descricaoController.text.trim(),
        caminhoImagem: _imagemSelecionada!.path,
      );

      if (!mounted) return;

      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Item salvo com sucesso!')),
      );

      Navigator.pushReplacementNamed(context, '/home');
    } catch (e) {
      setState(() => _erro = e.toString());
    } finally {
      if (mounted) setState(() => _salvando = false);
    }
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
              if (_erro != null) ...[
                Container(
                  width: double.infinity,
                  padding: const EdgeInsets.all(12),
                  decoration: BoxDecoration(
                    color: AppColors.danger.withValues(alpha: 0.15),
                    borderRadius: BorderRadius.circular(10),
                  ),
                  child: Text(_erro!, style: const TextStyle(color: Colors.white)),
                ),
                const SizedBox(height: 16),
              ],

              GestureDetector(
                onTap: _escolherImagem,
                child: Container(
                  width: double.infinity,
                  height: 160,
                  decoration: BoxDecoration(
                    color: Colors.white.withValues(alpha: 0.08),
                    borderRadius: BorderRadius.circular(12),
                    border: Border.all(color: Colors.white54),
                  ),
                  child: _imagemSelecionada == null
                      ? const Center(
                          child: Column(
                            mainAxisAlignment: MainAxisAlignment.center,
                            children: [
                              Icon(Icons.add_a_photo_outlined, color: Colors.white70, size: 32),
                              SizedBox(height: 8),
                              Text('Toque para escolher uma foto', style: TextStyle(color: Colors.white70)),
                            ],
                          ),
                        )
                      : ClipRRect(
                          borderRadius: BorderRadius.circular(12),
                          child: Image.file(File(_imagemSelecionada!.path), fit: BoxFit.cover),
                        ),
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
