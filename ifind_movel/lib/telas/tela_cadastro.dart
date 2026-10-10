import 'package:flutter/material.dart';
import 'package:webview_flutter/webview_flutter.dart';
import '../services/api_service.dart';
import '../theme/app_theme.dart';

class TelaWebRestrita extends StatefulWidget {
  final String titulo;
  final String caminho;

  const TelaWebRestrita({super.key, required this.titulo, required this.caminho});

  @override
  State<TelaWebRestrita> createState() => _TelaWebRestritaState();
}

class _TelaWebRestritaState extends State<TelaWebRestrita> {
  late final WebViewController _controller;
  bool _carregando = true;

  String _normalizar(String caminho) {
    if (caminho.length > 1 && caminho.endsWith('/')) {
      return caminho.substring(0, caminho.length - 1);
    }
    return caminho;
  }

  @override
  void initState() {
    super.initState();
    _controller = WebViewController()
      ..setJavaScriptMode(JavaScriptMode.unrestricted)
      ..setNavigationDelegate(
        NavigationDelegate(
          onNavigationRequest: (request) {
            if (!request.isMainFrame) return NavigationDecision.navigate;

            final destino = Uri.parse(request.url);
            final site = Uri.parse(ApiService.siteUrl);
            final mesmoSite = destino.host == site.host;

            if (mesmoSite && _normalizar(destino.path) == widget.caminho) {
              return NavigationDecision.navigate;
            }

            _aoBloquear(destino, mesmoSite);
            return NavigationDecision.prevent;
          },
          onPageFinished: (_) {
            if (mounted) setState(() => _carregando = false);
          },
        ),
      )
      ..loadRequest(Uri.parse('${ApiService.siteUrl}${widget.caminho}'));
  }

  @override
  void dispose() {
    WebViewCookieManager().clearCookies();
    super.dispose();
  }

  void _aoBloquear(Uri destino, bool mesmoSite) {
    if (!mounted) return;

    if (!mesmoSite) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Este link não está disponível no app.')),
      );
      return;
    }

    final caminho = _normalizar(destino.path);

    if (caminho == '/login') {
      Navigator.pop(context);
      return;
    }

    showDialog<void>(
      context: context,
      builder: (dialogContext) => AlertDialog(
        title: const Text('Voltar ao login?'),
        content: const Text(
          'Esta página só está disponível no site. Se você já concluiu a operação, volte e entre com seu e-mail e senha.',
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(dialogContext),
            child: const Text('Continuar aqui'),
          ),
          TextButton(
            onPressed: () {
              Navigator.pop(dialogContext);
              Navigator.pop(context);
            },
            child: const Text('Voltar ao login'),
          ),
        ],
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.primaryDark,
      appBar: AppBar(
        title: Text(widget.titulo),
      ),
      body: Stack(
        children: [
          WebViewWidget(controller: _controller),
          if (_carregando)
            const Center(child: CircularProgressIndicator(color: AppColors.accent)),
        ],
      ),
    );
  }
}

class TelaCadastro extends StatelessWidget {
  const TelaCadastro({super.key});

  @override
  Widget build(BuildContext context) {
    return const TelaWebRestrita(titulo: 'Cadastro', caminho: '/register');
  }
}

class TelaEsqueciSenha extends StatelessWidget {
  const TelaEsqueciSenha({super.key});

  @override
  Widget build(BuildContext context) {
    return const TelaWebRestrita(titulo: 'Recuperar senha', caminho: '/forgot-password');
  }
}
