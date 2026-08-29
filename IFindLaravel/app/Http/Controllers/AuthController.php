<?php

namespace App\Http\Controllers;

class AuthController extends Controller
{
    public function dashboard()
    {
        return view('dashboard');
    }
}
