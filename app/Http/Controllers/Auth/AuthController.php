<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('pages.auth.login', [
            'title' => 'Login',
        ]);
    }

    public function showProfile()
    {
        return view('pages.auth.profile', [
            'title' => 'Profil',
        ]);
    }
}
