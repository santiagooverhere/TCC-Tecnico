<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;

class AdminController extends Controller
{
    public function index() 
    {
        return view('admin.dashboard', [
            'totalPosts'      => Post::count(),
            'totalUsers'      => User::count(),
            'totalDevolvidos' => Post::whereNotNull('data_devolvida')->count(),
            'posts'           => Post::with('user')->latest()->paginate(6, ['*'], 'posts_page'),
            'users'           => User::withCount('posts')->latest()->paginate(6, ['*'], 'users_page'),
        ]);
    }
}