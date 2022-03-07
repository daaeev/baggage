<?php

namespace App\Http\Controllers\crud;

use App\Http\Controllers\Controller;
use App\Mail\OrderReceipt;
use App\Models\Receipt;
use App\Services\interfaces\BagsRepositoryInterface;
use App\Services\interfaces\OrdersRepositoryInterface;
use App\Services\interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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

    /**
     * Метод отвечает за подтверждение заказа на странице 'Orders' админ панели
     *
     * @param Request $request
     * @param OrdersRepositoryInterface $ordersRepository
     * @param UserRepositoryInterface $userRepository
     * @param BagsRepositoryInterface $bagsRepository
     * @return mixed
     */
    public function acceptOrder(Request $request, OrdersRepositoryInterface $ordersRepository, UserRepositoryInterface $userRepository, BagsRepositoryInterface $bagsRepository)
    {
        // Валидация данных
        $request->validate([
            'order_id' => 'required|exists:\App\Models\Order,id',
        ]);

        // Получение экземпляра заказа
        $order_id = $request->input('order_id');
        $order = $ordersRepository->getFistOrNull($order_id);

        // Получение экземпляра товара
        $bag = $bagsRepository->getFistOrNull($order->bag_id);

        // Сохранение данных в бд, используя транзакцию
        $receipt = new Receipt;

        $receipt->user_id = $order->user_id;
        $receipt->bag_id = $order->bag_id;
        $receipt->name = $order->name;
        $receipt->tel_number = $order->number;
        $receipt->order_number = Str::random(10);

        try {
            DB::transaction(function () use ($receipt, $bag, $order) {
                $receipt->save();
                $bag->increment('count', -1);
                $order->delete();
            });
        } catch (\Throwable) {
            $request->session()->flash('status_failed', "Order accept with id $order_id failed");

            return redirect(route('admin.orders'));
        }

        // Отправка чека на почту пользователя
        $mail = new OrderReceipt($receipt->order_number);
        Mail::to($userRepository->getAuthenticated()->email)->send($mail);

        $request->session()->flash('status_success', "Order accept success");

        return redirect(route('admin.orders'));
    }
}
