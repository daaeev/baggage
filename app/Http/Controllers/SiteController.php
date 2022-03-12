<?php

namespace App\Http\Controllers;

use App\Models\Bag;
use App\Services\interfaces\BagsRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * Рендер страницы с формой создания заказа
     *
     * @param string $bag_slug знечение поля slug модели \App\Models\Bag
     * @return mixed
     */
    public function orderForm($bag_slug)
    {
        return view('order_form', compact('bag_slug'));
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
     * @param Bag $bag экземпляр модели \App\Models\Bag
     * @return mixed
     */
    public function single(Bag $bag, BagsRepositoryInterface $bagsRepository)
    {
        $featured = $bagsRepository->getBagsLimitCond($bag);

        return view('single', compact('bag', 'featured'));
    }
}
