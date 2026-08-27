class Post {
  final int? id; // null enquanto ainda não foi salvo no banco
  final String titulo;
  final String descricao;
  final String nomeItem;
  final String? imagemUrl; // caminho do arquivo da imagem
  final String dataEncontrada; // preenchida na hora de criar
  final String? dataDevolvida; // null até ser marcado como devolvido
  final String createdAt;

  Post({
    this.id,
    required this.titulo,
    required this.descricao,
    required this.nomeItem,
    this.imagemUrl,
    required this.dataEncontrada,
    this.dataDevolvida,
    required this.createdAt,
  });

  // Converte o objeto Dart em um Map pro sqlite entender
  Map<String, dynamic> toMap() {
    return {
      'id': id,
      'titulo': titulo,
      'descricao': descricao,
      'nome_item': nomeItem,
      'imagem_url': imagemUrl,
      'data_encontrada': dataEncontrada,
      'data_devolvida': dataDevolvida,
      'created_at': createdAt,
    };
  }

  factory Post.fromMap(Map<String, dynamic> map) {
    return Post(
      id: map['id'] as int?,
      titulo: map['titulo'] as String,
      descricao: map['descricao'] as String,
      nomeItem: map['nome_item'] as String,
      imagemUrl: map['imagem_url'] as String?,
      dataEncontrada: map['data_encontrada'] as String,
      dataDevolvida: map['data_devolvida'] as String?,
      createdAt: map['created_at'] as String,
    );
  }

  Post copyWith({String? dataDevolvida}) {
    return Post(
      id: id,
      titulo: titulo,
      descricao: descricao,
      nomeItem: nomeItem,
      imagemUrl: imagemUrl,
      dataEncontrada: dataEncontrada,
      dataDevolvida: dataDevolvida ?? this.dataDevolvida,
      createdAt: createdAt,
    );
  }
}
