import 'package:flutter/material.dart';
import 'dart:async';

class HomePage extends StatefulWidget {
  const HomePage({super.key});

  @override
  State<HomePage> createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  int _indiceAtual = 0;

  final List<Widget> _telas = [
    const Center(child: Text('Lista de Posts')),
    const Center(child: Text('Formulário de Criação')),
  ];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        backgroundColor: Theme.of(context).colorScheme.inversePrimary,
        automaticallyImplyLeading: false,
        title: const Text('Menu Principal'),
      ),
      body: _telas[_indiceAtual],
      bottomNavigationBar: BottomNavigationBar(
        currentIndex: _indiceAtual,
        items: const[
          BottomNavigationBarItem(icon: Icon(Icons.home), label: 'Posts'),
          BottomNavigationBarItem(icon: Icon(Icons.create), label: 'Criar')
        ],
        onTap: (indiceClicado){
          setState(() {
            _indiceAtual = indiceClicado;
          });
        },
      ),
    );
  }
}