import 'package:flutter/material.dart';
import 'dart:async';
import 'tela_criar.dart';
import 'tela_posts.dart';

class HomePage extends StatefulWidget {
  const HomePage({super.key});

  @override
  State<HomePage> createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  int _indiceAtual = 0;

  final List<Widget> _telas = [
    const TelaPosts(),
    const TelaCriar(),
  ];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
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