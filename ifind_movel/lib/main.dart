import 'package:flutter/material.dart';
import 'dart:async';
import 'package:webview_flutter/webview_flutter.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Flutter Demo',
      theme: ThemeData(
        colorScheme: .fromSeed(seedColor: Colors.deepPurple),
      ),
      initialRoute: '/',
      routes: {
        '/': (context) => const SplashInicial(),
        '/login': (context) => const TelaLogin(),
      },
    );
  }
}

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

class TelaLogin extends StatefulWidget { //Tela de Login
  const TelaLogin({super.key});

  @override
  State<TelaLogin> createState() => _TelaLoginState();
}

class _TelaLoginState extends State<TelaLogin> { //Tela de Login por WebView
  // Declaração do controlador
  late final WebViewController controller;
  @override
  void initState() {
    super.initState();

    controller = WebViewController() //operador em cascata
      ..setJavaScriptMode(JavaScriptMode.unrestricted) // necessário para os botões e formulários funcionarem
      ..loadRequest(Uri.parse('http://127.0.0.1:8000/login')) //string - link
      ..setNavigationDelegate(
        NavigationDelegate(
          onPageFinished: (String url) {
            if (url.contains('/home')) {
            Navigator.pushReplacementNamed(context, '/splash_pos_login');
            }
          },
        ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Login')),
      body: WebViewWidget(controller: controller),
    );
  }
}

class SplashLogin extends StatefulWidget{
  const SplashLogin({super.key});

  @override
  State<SplashLogin> createState() => _SplashLoginState();
}

class _SplashLoginState extends State<SplashLogin> {
  @override
  void initState() {
    super.initState();
    Timer(const Duration(seconds: 2), () {
      Navigator.pushReplacementNamed(context, '/menu');
    });
  }
  @override
  Widget build(BuildContext context) {
    return const Scaffold(
      body: Center(
        child: Text('Carregando Dados...'),
      ),
    );
  }
}

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