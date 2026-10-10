import 'package:flutter/material.dart';
import '../services/api_service.dart';
import '../theme/app_theme.dart';

class RotaProtegida extends StatelessWidget {
  final Widget child;

  const RotaProtegida({super.key, required this.child});

  @override
  Widget build(BuildContext context) {
    return FutureBuilder<bool>(
      future: ApiService.instance.estaLogado,
      builder: (context, snapshot) {
        if (snapshot.connectionState != ConnectionState.done) {
          return const Scaffold(
            backgroundColor: AppColors.primaryDark,
            body: Center(child: CircularProgressIndicator(color: AppColors.accent)),
          );
        }

        if (snapshot.data != true) {
          WidgetsBinding.instance.addPostFrameCallback((_) {
            if (!context.mounted) return;
            Navigator.pushNamedAndRemoveUntil(context, '/login', (route) => false);
          });
          return const Scaffold(backgroundColor: AppColors.primaryDark);
        }

        return child;
      },
    );
  }
}
