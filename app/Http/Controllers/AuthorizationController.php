<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthorizationController extends Controller
{
    /**
     * Метод отвечает за рендеринг страницы авторизации
     */
    public function login()
    {
        return view('login');
    }

    /**
     * Метод отвечает за рендеринг страницы регистрации
     */
    public function register()
    {
        return view('register');
    }
}
