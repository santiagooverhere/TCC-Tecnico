import 'package:flutter/material.dart';
import '../theme/app_theme.dart';

class TelaCadastro extends StatelessWidget {
  const TelaCadastro({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.primaryDark,
      appBar: AppBar(
        title: const Text("Cadastro"),
      ),
      body: const Center(
        child: Text(
          "Web View de cadastro aqui",
          style: TextStyle(color: Colors.white),
        ),
      ),
    );
  }
}
