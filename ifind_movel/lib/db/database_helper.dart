import 'package:sqflite/sqflite.dart';
import 'package:path/path.dart';
import '../models/post_model.dart';

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
      version: 1,
      onCreate: _onCreate,
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
}
