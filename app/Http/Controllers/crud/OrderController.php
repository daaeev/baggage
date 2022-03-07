<?php

namespace App\Http\Controllers\crud;

use App\Http\Controllers\Controller;
use App\Services\interfaces\OrdersRepositoryInterface;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Метод отвечает за отклонение заказа (его удаление из таблицы 'orders')
     *
     * @param Request $request
     * @param OrdersRepositoryInterface $ordersRepository
     * @return mixed
     */
    public function declineOrder(Request $request, OrdersRepositoryInterface $ordersRepository)
    {
        // Валидация данных
        $request->validate([
            'order_id' => 'required|exists:\App\Models\Order,id',
        ]);

        // Получение экземпляра заказа
        $order_id = $request->input('order_id');
        $order = $ordersRepository->getFistOrNull($order_id);

        // Удаление данных из БД
        if (!$order->delete()) {
            $request->session()->flash('status_failed', "Order decline with id $order_id failed");

            return redirect(route('admin.orders'));
        }

        $request->session()->flash('status_success', "Order decline success");

        return redirect(route('admin.orders'));
    }
}
