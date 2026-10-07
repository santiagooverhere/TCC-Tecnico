class Autor {
  final int id;
  final String name;
  final String email;

  Autor({required this.id, required this.name, required this.email});

  factory Autor.fromJson(Map<String, dynamic> json) {
    return Autor(
      id: json['id'] as int,
      name: json['name'] as String,
      email: json['email'] as String,
    );
  }
}

class Post {
  final int? id;
  final String nomeItem;
  final String? descricao;
  final String imagemUrl;
  final String? dataEncontrada;
  final String? dataDevolvida;
  final int? usersId;
  final Autor? autor;

  Post({
    this.id,
    required this.nomeItem,
    this.descricao,
    required this.imagemUrl,
    this.dataEncontrada,
    this.dataDevolvida,
    this.usersId,
    this.autor,
  });

  factory Post.fromJson(Map<String, dynamic> json) {
    return Post(
      id: json['id'] as int?,
      nomeItem: json['nome_item'] as String,
      descricao: json['descricao'] as String?,
      imagemUrl: json['imagem_url'] as String,
      dataEncontrada: json['data_encontrada'] as String?,
      dataDevolvida: json['data_devolvida'] as String?,
      usersId: json['users_id'] as int?,
      autor: json['autor'] != null ? Autor.fromJson(json['autor']) : null,
    );
  }
}
