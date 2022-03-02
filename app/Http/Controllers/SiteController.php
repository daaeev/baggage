<?php

namespace App\Http\Controllers;

use App\Models\Bag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiteController extends Controller
{
    /**
     * Метод отвечает за рендер главной страницы
     */
    public function index()
    {
        return view('index');
    }

    /**
     * Метод отвечает за рендер страницы о магазине
     */
    public function about()
    {
        return view('about');
    }

    /**
     * Метод отвечает за рендер страницы связи с компанией
     */
    public function contact()
    {
        return view('contact');
    }

    /**
     * Метод отвечает за рендер страницы каталога товаров
     */
    public function catalog()
    {
        return view('catalog');
    }

    /**
     * Метод отвечает за рендер страницы подписка на рассылку
     */
    public function newsletter()
    {
        return view('newsletter');
    }

    /**
     * Метод отвечает за рендер страницы профиля
     */
    public function profile()
    {
        $user = Auth::user();

        return view('profile', compact('user'));
    }

    /**
     * Метод отвечает за рендер страницы просмотра товара
     */
    public function single(Bag $bag)
    {
        return view('single', compact('bag'));
    }
}
