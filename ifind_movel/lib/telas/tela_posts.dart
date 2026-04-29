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
      backgroundColor: Colors.green[800],
      appBar: AppBar(
        backgroundColor: Colors.green[900],
        title: const Text("Achados e Perdidos", style: TextStyle(color: Colors.white)),
        centerTitle: true,
      ),
      body: ListView.builder(
        padding: const EdgeInsets.all(8.0),
        itemCount: 5,
        itemBuilder: (context, index){
          return Card(
            elevation: 3.0,
            color: Colors.white,
            child: ListTile(
              title: Text("Item encontrado $index", style: const TextStyle(fontWeight: FontWeight.bold)),
              subtitle: const Text("Descrição do item"),
              leading: Container(
                width: 50,
                height: 50,
                color: Colors.grey[300],
                child: const Icon(Icons.camera_alt, color: Colors.grey),
              ),
              trailing: Row(
                mainAxisSize: MainAxisSize.min,
                children: [
                  IconButton(
                    icon: Icon(Icons.comment, color: Colors.green[800]),
                    onPressed: () {
                      showDialog(context: context,
                          builder: (BuildContext context) {
                            return AlertDialog(
                              title: const Text("Comentarios"),
                              content: const Text("Aqui será a aba de comentários"),
                              actions: [
                                TextButton(onPressed: (){
                                  Navigator.of(context).pop();
                                }, child: const Text('ok'),
                                ),
                              ],
                            );
                          },
                      );
                    },
                  ),
                  IconButton(
                    icon: Icon(Icons.share, color: Colors.green[800]),
                    onPressed: () {
                      showDialog(context: context,
                          builder: (BuildContext context) {
                            return  AlertDialog(
                              title: const Text('Whastapp'),
                              content: const Text('Aqui será o compartilhamento do post para Whatsapp'),
                              actions: [
                                TextButton(onPressed: (){
                                  Navigator.of(context).pop();
                                }, child: const Text("ok"))
                              ],
                            );
                          }
                      );
                    },
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