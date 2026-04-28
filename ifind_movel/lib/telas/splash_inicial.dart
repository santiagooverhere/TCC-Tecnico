import 'package:flutter/material.dart';
import 'dart:async';

class SplashInicial extends StatefulWidget{
  const SplashInicial({super.key});

  @override
  State<SplashInicial> createState() => _SplashInicialState();
}

class _SplashInicialState extends State<SplashInicial> {
  @override
  void initState() {
    super.initState();
    Timer(const Duration(seconds: 3), () {
      Navigator.pushReplacementNamed(context, '/login');
    });
  }
  @override
  Widget build(BuildContext context) {
    return const Scaffold(
      body: Center(
        child: Text('Bem-vindo'),
      ),
    );
  }
}