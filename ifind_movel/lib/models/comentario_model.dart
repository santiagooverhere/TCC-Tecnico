class Comentario {
  final int? id;
  final int usersId;
  final int postId;
  final String nameUser;
  final String texto;
  final String createdAt;

  Comentario({
    this.id,
    required this.usersId,
    required this.postId,
    required this.nameUser,
    required this.texto,
    required this.createdAt,
  });

  Map<String, dynamic> toMap() {
    return {
      'id': id,
      'users_id': usersId,
      'post_id': postId,
      'name_user': nameUser,
      'texto': texto,
      'created_at': createdAt,
    };
  }

  factory Comentario.fromMap(Map<String, dynamic> map) {
    return Comentario(
      id: map['id'] as int?,
      usersId: map['users_id'] as int,
      postId: map['post_id'] as int,
      nameUser: map['name_user'] as String,
      texto: map['texto'] as String,
      createdAt: map['created_at'] as String,
    );
  }
}
