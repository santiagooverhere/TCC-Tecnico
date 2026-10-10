import 'package:flutter/material.dart';
import 'theme/app_theme.dart';
import 'telas/splash_inicial.dart';
import 'telas/tela_login.dart';
import 'telas/tela_cadastro.dart';
import 'telas/splash_login.dart';
import 'telas/home_page.dart';
import 'telas/rota_protegida.dart';
import 'services/navegacao.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'IFIND',
      debugShowCheckedModeBanner: false,
      navigatorKey: navigatorKey,
      theme: AppTheme.theme,
      initialRoute: '/',
      routes: {
        '/': (context) => const SplashInicial(),
        '/login': (context) => const TelaLogin(),
        '/splash': (context) => const RotaProtegida(child: SplashLogin()),
        '/cadastro': (context) => const TelaCadastro(),
        '/esqueci-senha': (context) => const TelaEsqueciSenha(),
        '/home': (context) => const RotaProtegida(child: HomePage()),
      },
    );
  }
}
