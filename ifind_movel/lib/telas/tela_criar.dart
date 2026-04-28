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
      backgroundColor: Colors.green[800], // Fundo verde aplicado!
      appBar: AppBar(
        backgroundColor: Colors.green[900],
        title: const Text("Achados e Perdidos", style: TextStyle(color: Colors.white)),
        centerTitle: true,
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          children: [
            TextField(
              controller: _tituloController,
              style: const TextStyle(color: Colors.white), // Deixa o texto digitado branco
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

            TextField(
              controller: _descricaoController,
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

            TextField(
              controller: _nomeItemController,
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
              onPressed: () {
                Navigator.pushReplacementNamed(context, '/home');
              },
              style: ElevatedButton.styleFrom(
                backgroundColor: Colors.green[900], // Verde escuro no botão
                foregroundColor: Colors.white,
                padding: const EdgeInsets.symmetric(horizontal: 50, vertical: 15),
              ),
              child: const Text("Finalizar"),
            ),
          ],
        ),
      ),
    );
  }
}