<?php

namespace App\Http\Controllers;

use App\Models\Bag;
use App\Services\interfaces\BagsRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SiteController extends Controller
{
    /**
     * Метод отвечает за рендер главной страницы
     *
     * @return mixed
     */
    public function index()
    {
        return view('index');
    }

    /**
     * Метод отвечает за рендер страницы о магазине
     *
     * @return mixed
     */
    public function about()
    {
        return view('about');
    }

    /**
     * Метод отвечает за рендер страницы связи с компанией
     *
     * @return mixed
     */
    public function contact()
    {
        return view('contact');
    }

    /**
     * Метод отвечает за рендер страницы каталога товаров
     *
     * @param BagsRepositoryInterface $bagsRepository
     * @param Request $request
     * @return mixed
     */
    public function catalog(BagsRepositoryInterface $bagsRepository, Request $request)
    {
        // Строка по которой производится поиск в таблице 'bags'
        $search = $request->query('search');

        $catalog = $search ? $bagsRepository->getAllBySearchWithPag($search) : $bagsRepository->getAllWithPag();

        return view('catalog', compact('catalog', 'search'));
    }

    /**
     * Метод отвечает за рендер страницы подписка на рассылку
     *
     * @return mixed
     */
    public function newsletter()
    {
        return view('newsletter');
    }

    /**
     * Метод отвечает за рендер страницы профиля
     *
     * @return mixed
     */
    public function profile()
    {
        $user = Auth::user();

        return view('profile', compact('user'));
    }

    /**
     * Метод отвечает за рендер страницы просмотра товара
     *
     * @param Bag $bag экземпляр товара из таблицы 'bags'
     * @return mixed
     */
    public function single(Bag $bag)
    {
        return view('single', compact('bag'));
    }
}
