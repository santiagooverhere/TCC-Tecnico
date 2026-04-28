import 'package:flutter/material.dart';
import 'dart:async';

class SplashLogin extends StatefulWidget{
  const SplashLogin({super.key});

  @override
  State<SplashLogin> createState() => _SplashLoginState();
}

class _SplashLoginState extends State<SplashLogin> {
  @override
  void initState() {
    super.initState();
    Timer(const Duration(seconds: 3), () {
      Navigator.pushReplacementNamed(context, '/home');
    });
  }
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.green,
      body: Center(
          child: Column(
            mainAxisAlignment: .center,
            children: [
              Icon(Icons.search, size: 80, color: Colors.green[900]),
              SizedBox(height: 20),
              Text("Bem vindo!",
                  style: TextStyle(
                    color: Colors.green[900],
                    fontSize: 24,
                  )
              ),
              SizedBox(height: 10),
              CircularProgressIndicator(color: Colors.white)
            ],
          )
      ),
    );
  }
}