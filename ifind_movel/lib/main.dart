import 'package:flutter/material.dart';
import 'theme/app_theme.dart';
import 'telas/splash_inicial.dart';
import 'telas/tela_login.dart';
import 'telas/tela_cadastro.dart';
import 'telas/splash_login.dart';
import 'telas/home_page.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'IFIND',
      theme: AppTheme.theme,
      initialRoute: '/',
      routes: {
        '/': (context) => const SplashInicial(),
        '/login': (context) => const TelaLogin(),
        '/splash': (context) => const SplashLogin(),
        '/cadastro': (context) => const TelaCadastro(),
        '/home': (context) => const HomePage(),
      },
    );
  }
}
