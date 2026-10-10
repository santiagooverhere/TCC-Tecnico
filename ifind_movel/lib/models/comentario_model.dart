class Comentario {
  final int? id;
  final int usersId;
  final int postId;
  final String nameUser;
  final String texto;
  final String? createdAt;

  Comentario({
    this.id,
    required this.usersId,
    required this.postId,
    required this.nameUser,
    required this.texto,
    this.createdAt,
  });

  factory Comentario.fromJson(Map<String, dynamic> json) {
    return Comentario(
      id: json['id'] as int?,
      usersId: json['users_id'] as int,
      postId: json['post_id'] as int,
      nameUser: json['name_user'] as String,
      texto: (json['texto'] as String?) ?? '',
      createdAt: json['created_at'] as String?,
    );
  }
}
