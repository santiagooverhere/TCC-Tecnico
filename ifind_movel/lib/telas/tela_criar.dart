import 'package:flutter/material.dart';
import 'dart:async';

class TelaCriar extends StatefulWidget{
  const TelaCriar({super.key});

  @override
  State<TelaCriar> createState() => _TelaCriarState();
}

class _TelaCriarState extends State<TelaCriar> {
  final _tituloController = TextEditingController();
  final _descricaoController = TextEditingController();
  final _nomeItemController = TextEditingController();

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          children: [
            TextField(
              controller: _tituloController,
              decoration: const InputDecoration(
                labelText: 'Título',
              ),
            ),

            TextField(
              controller: _descricaoController,
              decoration: const InputDecoration(
                labelText: 'Descrição',
              ),
            ),

            TextField(
              controller: _nomeItemController,
              decoration: const InputDecoration(
                labelText: 'Nome do item',
              ),
            ),

            ElevatedButton(
              onPressed: () {
                Navigator.pushReplacementNamed(context, '/home');
              },
              child: Text("Finalizar"),
            ),
          ],
        ),
      ),
    );
  }
}