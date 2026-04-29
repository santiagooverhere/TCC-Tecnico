<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function dashboard() {
        return view('dashboard');
    }

    public function login() {
        return view('auth.login');
    }

    public function register() {
        return view('auth.register');
    }
}
