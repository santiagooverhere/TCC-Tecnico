import 'package:flutter/material.dart';
import 'dart:async';
import '../theme/app_theme.dart';
import '../services/api_service.dart';

class SplashInicial extends StatefulWidget{
  const SplashInicial({super.key});

  @override
  State<SplashInicial> createState() => _SplashInicialState();
}

class _SplashInicialState extends State<SplashInicial> {
  @override
  void initState() {
    super.initState();
    _verificarLogin();
  }

  Future<void> _verificarLogin() async {
    final logado = await ApiService.instance.sessaoValida();
    await Future.delayed(const Duration(seconds: 2));
    if (!mounted) return;
    Navigator.pushReplacementNamed(context, logado ? '/home' : '/login');
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.primaryDark,
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Container(
              width: 96,
              height: 96,
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(24),
              ),
              child: const Icon(Icons.search, size: 52, color: AppColors.primary),
            ),
            const SizedBox(height: 24),
            const Text(
              "IFIND",
              style: TextStyle(
                color: Colors.white,
                fontSize: 28,
                fontWeight: FontWeight.bold,
                letterSpacing: 1.2,
              ),
            ),
            const SizedBox(height: 8),
            Text(
              "Achados e Perdidos",
              style: TextStyle(color: Colors.white.withValues(alpha: 0.7), fontSize: 14),
            ),
            const SizedBox(height: 32),
            const CircularProgressIndicator(color: AppColors.accent),
          ],
        )
      ),
    );
  }
}
