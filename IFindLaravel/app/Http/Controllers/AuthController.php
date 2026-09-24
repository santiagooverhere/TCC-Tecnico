<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function dashboard(Request $request)
    {
        $query = Post::with('user')->latest();

        // Busca por texto
        if ($request->filled('busca')) {
            $termo = $request->input('busca');
            $query->where(function ($q) use ($termo) {
                $q->where('nome_item', 'like', "%{$termo}%")
                  ->orWhere('descricao', 'like', "%{$termo}%");
            });
        }

        // Filtro por status
        if ($request->input('tipo') === 'achado') {
            $query->whereNull('data_devolvida');
        } elseif ($request->input('tipo') === 'devolvido') {
            $query->whereNotNull('data_devolvida');
        }

        $posts = $query->paginate(8)->withQueryString();

        return view('dashboard', [
            'posts'           => $posts,
            'totalPosts'      => Post::count(),
            'totalDevolvidos' => Post::whereNotNull('data_devolvida')->count(),
        ]);
    }
}
