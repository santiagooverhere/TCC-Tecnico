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
      body: Center(

      ),
    );
  }
}