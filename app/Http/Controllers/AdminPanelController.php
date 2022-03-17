<?php

namespace App\Http\Controllers;

use App\Http\Requests\BagEditForm;
use App\Models\User;
use App\Services\interfaces\BagsRepositoryInterface;
use App\Services\interfaces\OrdersRepositoryInterface;
use App\Services\interfaces\ReceiptRepositoryInterface;
use App\Services\interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use ViewComponents\ViewComponents\Input\InputSource;

class AdminPanelController extends Controller
{
    /**
     * @param Request $request
     */
    public function __construct(protected Request $request)
    {
    }

    /**
     * Метод отвечает за рендер страницы 'Users' админ панели
     *
     * @param UserRepositoryInterface $userRepository
     * @return mixed
     */
    public function usersList(UserRepositoryInterface $userRepository)
    {
        $input = new InputSource($this->request->query());
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
        $input = new InputSource($this->request->query());
        $grid = $bagsRepository->getAllUsingGrid($input);

        return view('admin.bags', compact('grid'));
    }

    /**
     * Метод отвечает за рендер страницы 'Orders' админ панели
     *
     * @param OrdersRepositoryInterface $ordersRepository
     * @return mixed
     */
    public function ordersList(OrdersRepositoryInterface $ordersRepository)
    {
        $input = new InputSource($this->request->query());
        $grid = $ordersRepository->getAllUsingGrid($input);

        return view('admin.orders', compact('grid'));
    }

    /**
     * Метод отвечает за рендер страницы 'Receipts' админ панели
     *
     * @param OrdersRepositoryInterface $ordersRepository
     * @return mixed
     */
    public function receiptsList(ReceiptRepositoryInterface $receiptRepository)
    {
        $input = new InputSource($this->request->query());
        $grid = $receiptRepository->getAllUsingGrid($input);

        return view('admin.receipts', compact('grid'));
    }

    /**
     * Метод отвечает за рендер страницы с формой создания товара в админ панели
     *
     * @return mixed
     */
    public function bagCreateForm()
    {
        return view('admin.bags_create_form');
    }

    /**
     * Метод отвечает за рендер страницы с формой редактирования товара в админ панели
     *
     * @param BagsRepositoryInterface $bagsRepository
     * @param BagEditForm $validation
     * @return mixed
     */
    public function bagEditForm(
        BagsRepositoryInterface $bagsRepository,
        BagEditForm $validation
    )
    {
        $bag_id = $this->request->query('id');
        $bag = $bagsRepository->getFistOrNull($bag_id);

        return view('admin.bags_edit_form', compact('bag'));
    }
}
