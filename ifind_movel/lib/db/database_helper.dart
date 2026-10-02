import 'package:sqflite/sqflite.dart';
import 'package:path/path.dart';
import '../models/post_model.dart';
import '../models/comentario_model.dart';

class DatabaseHelper {
  DatabaseHelper._internal();
  static final DatabaseHelper instance = DatabaseHelper._internal();

  static Database? _database;

  Future<Database> get database async { // getter
    if (_database != null) return _database!;
    _database = await _initDatabase();
    return _database!;
  }

  Future<Database> _initDatabase() async {
    final path = join(await getDatabasesPath(), 'ifind.db');
    return await openDatabase(
      path,
      version: 2,
      onCreate: _onCreate,
      onUpgrade: _onUpgrade,
    );
  }

  Future<void> _onCreate(Database db, int version) async {
    await db.execute('''
      CREATE TABLE posts (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        titulo TEXT NOT NULL,
        descricao TEXT NOT NULL,
        nome_item TEXT NOT NULL,
        imagem_url TEXT,
        data_encontrada TEXT NOT NULL,
        data_devolvida TEXT,
        created_at TEXT NOT NULL
      )
    ''');
    await _criarTabelaComentarios(db);
  }

  Future<void> _onUpgrade(Database db, int oldVersion, int newVersion) async {
    if (oldVersion < 2) {
      await _criarTabelaComentarios(db);
    }
  }

  Future<void> _criarTabelaComentarios(Database db) async {
    await db.execute('''
      CREATE TABLE comentarios (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        users_id INTEGER NOT NULL,
        post_id INTEGER NOT NULL,
        name_user TEXT NOT NULL,
        texto TEXT NOT NULL,
        created_at TEXT NOT NULL,
        FOREIGN KEY (post_id) REFERENCES posts (id) ON DELETE CASCADE
      )
    ''');
  }

  Future<int> inserirPost(Post post) async {
    final db = await database;
    return await db.insert('posts', post.toMap()..remove('id'));
  }

  Future<List<Post>> listarPosts() async {
    final db = await database;
    final resultado = await db.query('posts', orderBy: 'id DESC');
    return resultado.map((linha) => Post.fromMap(linha)).toList();
  }

  Future<int> excluirPost(int id) async {
    final db = await database;
    return await db.delete('posts', where: 'id = ?', whereArgs: [id]);
  }

  Future<int> marcarComoDevolvido(int id) async {
    final db = await database;
    return await db.update(
      'posts',
      {'data_devolvida': DateTime.now().toIso8601String()},
      where: 'id = ?',
      whereArgs: [id],
    );
  }

  Future<int> inserirComentario(Comentario comentario) async {
    final db = await database;
    return await db.insert('comentarios', comentario.toMap()..remove('id'));
  }

  Future<List<Comentario>> listarComentariosPorPost(int postId) async {
    final db = await database;
    final resultado = await db.query(
      'comentarios',
      where: 'post_id = ?',
      whereArgs: [postId],
      orderBy: 'id DESC',
    );
    return resultado.map((linha) => Comentario.fromMap(linha)).toList();
  }

  Future<int> excluirComentario(int id) async {
    final db = await database;
    return await db.delete('comentarios', where: 'id = ?', whereArgs: [id]);
  }
}
