import 'dart:io';
import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';
import '../models/post_model.dart';
import '../services/api_service.dart';
import '../theme/app_theme.dart';
import '../widgets/seletor_data_hora.dart';

class TelaEditar extends StatefulWidget {
  final Post post;

  const TelaEditar({super.key, required this.post});

  @override
  State<TelaEditar> createState() => _TelaEditarState();
}

class _TelaEditarState extends State<TelaEditar> {
  final _formKey = GlobalKey<FormState>();
  late final TextEditingController _descricaoController;
  late final TextEditingController _nomeItemController;
  late DateTime _dataEncontrada;

  XFile? _novaImagem;
  bool _salvando = false;
  String? _erro;

  @override
  void initState() {
    super.initState();
    _descricaoController = TextEditingController(text: widget.post.descricao ?? '');
    _nomeItemController = TextEditingController(text: widget.post.nomeItem);
    final data = DateTime.tryParse(widget.post.dataEncontrada ?? '')?.toLocal();
    _dataEncontrada = (data == null || data.isAfter(DateTime.now())) ? DateTime.now() : data;
  }

  @override
  void dispose() {
    _descricaoController.dispose();
    _nomeItemController.dispose();
    super.dispose();
  }

  Future<void> _escolherImagem() async {
    final imagem = await ImagePicker().pickImage(
      source: ImageSource.gallery,
      imageQuality: 85,
      maxWidth: 1600,
    );
    if (imagem != null) {
      setState(() => _novaImagem = imagem);
    }
  }

  Future<void> _salvar() async {
    if (!_formKey.currentState!.validate()) return;

    setState(() {
      _salvando = true;
      _erro = null;
    });

    try {
      await ApiService.instance.editarPost(
        widget.post.id!,
        nomeItem: _nomeItemController.text.trim(),
        descricao: _descricaoController.text.trim(),
        dataEncontrada: _dataEncontrada,
        caminhoImagem: _novaImagem?.path,
      );

      if (!mounted) return;

      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Item atualizado com sucesso!')),
      );

      Navigator.pop(context, true);
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
        title: const Text("Editar item"),
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
                  height: 200,
                  decoration: BoxDecoration(
                    color: Colors.white.withValues(alpha: 0.08),
                    borderRadius: BorderRadius.circular(12),
                    border: Border.all(color: Colors.white54),
                  ),
                  child: ClipRRect(
                    borderRadius: BorderRadius.circular(12),
                    child: Stack(
                      fit: StackFit.expand,
                      children: [
                        _novaImagem == null
                            ? Image.network(
                                widget.post.imagemUrl,
                                fit: BoxFit.cover,
                                errorBuilder: (context, error, stack) => const Center(
                                  child: Icon(Icons.image_outlined, color: Colors.white70, size: 40),
                                ),
                              )
                            : Image.file(File(_novaImagem!.path), fit: BoxFit.cover),
                        Positioned(
                          right: 8,
                          bottom: 8,
                          child: Container(
                            padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 6),
                            decoration: BoxDecoration(
                              color: Colors.black54,
                              borderRadius: BorderRadius.circular(20),
                            ),
                            child: const Row(
                              mainAxisSize: MainAxisSize.min,
                              children: [
                                Icon(Icons.edit, color: Colors.white, size: 14),
                                SizedBox(width: 6),
                                Text('Trocar foto', style: TextStyle(color: Colors.white, fontSize: 12)),
                              ],
                            ),
                          ),
                        ),
                      ],
                    ),
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

              SeletorDataHora(
                valor: _dataEncontrada,
                onChanged: (nova) => setState(() => _dataEncontrada = nova),
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
                  onPressed: _salvando ? null : _salvar,
                  child: _salvando
                      ? const SizedBox(
                          width: 20,
                          height: 20,
                          child: CircularProgressIndicator(color: Colors.white, strokeWidth: 2),
                        )
                      : const Text("Salvar alterações"),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
