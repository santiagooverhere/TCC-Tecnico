import 'package:flutter/material.dart';
import 'dart:async';

class TelaPosts extends StatefulWidget{
  const TelaPosts({super.key});

  @override
  State<TelaPosts> createState() => _TelaPostsState();
}

class _TelaPostsState extends State<TelaPosts> {

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body:
      ListView.builder(
          itemCount: 5,
          itemBuilder: (context, index){
            return
            Card(
              elevation: 3.0,
              child:
              ListTile(
                title: Text("Item encontrado $index"),

                subtitle: Text("Descrição do item"),
                leading:

                Container(
                  width: 50,
                  height: 50,
                  color: Colors.grey[300],
                  child: const Icon(Icons.camera_alt, color: Colors.grey),
                ),

                trailing: Row(
                  mainAxisSize: .min,
                  children: [
                    IconButton(
                      icon: const Icon(Icons.comment),
                      onPressed: () {},
                    ),

                    IconButton(
                      icon: const Icon(Icons.share),
                      onPressed: () {},
                    )
                  ],
                ),
              ),
            );
        },
      ),
    );
  }
}