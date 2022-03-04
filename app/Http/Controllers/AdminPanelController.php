<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\interfaces\BagsRepositoryInterface;
use App\Services\interfaces\UserRepositoryInterface;
use ViewComponents\ViewComponents\Input\InputSource;

class AdminPanelController extends Controller
{
    /**
     * Метод отвечает за рендер страницы 'Users' админ панели
     *
     * @param UserRepositoryInterface $userRepository
     * @return mixed
     */
    public function usersList(UserRepositoryInterface $userRepository)
    {
        $input = new InputSource(request()->query());
        $grid = $userRepository->getAllUsingGrid($input);

        return view('admin.users', compact('grid'));
    }

    /**
     * Метод отвечает за рендер страницы 'Bags' админ панели
     *
     * @param BagsRepositoryInterface $bagsRepository
     * @return mixed
     */
    public function bagsList(BagsRepositoryInterface $bagsRepository)
    {
        $input = new InputSource(request()->query());
        $grid = $bagsRepository->getAllUsingGrid($input);

        return view('admin.bags', compact('grid'));
    }
}
