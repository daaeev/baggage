<?php

namespace App\Http\Controllers\crud;

use App\Http\Controllers\Controller;
use App\Http\Requests\AcceptDeclineOrder;
use App\Mail\OrderReceipt;
use App\Models\Receipt;
use App\Services\interfaces\BagsRepositoryInterface;
use App\Services\interfaces\MailSenderInterface;
use App\Services\interfaces\OrdersRepositoryInterface;
use App\Services\interfaces\UserRepositoryInterface;
use App\Services\traits\ReturnWithRedirectAndFlash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    use ReturnWithRedirectAndFlash;

    /**
     * @param Request $request
     */
    public function __construct(protected Request $request)
    {
    }

    /**
     * Метод отвечает за отклонение заказа (его удаление из таблицы 'orders')
     * @param OrdersRepositoryInterface $ordersRepository
     * @param AcceptDeclineOrder $validation
     * @return mixed
     */
    public function declineOrder(
        OrdersRepositoryInterface $ordersRepository,
        AcceptDeclineOrder $validation
    )
    {
        // Получение экземпляра заказа
        $order_id = $this->request->input('order_id');
        $order = $ordersRepository->getFirstOrNull($order_id);

        // Удаление данных из БД
        if (!$order->delete()) {
            return $this->withRedirectAndFlash(
                'status_failed',
                'Order decline with id $order_id failed',
                route('admin.orders'),
                $this->request
            );
        }

        return $this->withRedirectAndFlash(
            'status_success',
            'Order decline success',
            route('admin.orders'),
            $this->request
        );
    }

    /**
     * Метод отвечает за подтверждение заказа на странице 'Orders' админ панели
     *
     * @param OrdersRepositoryInterface $ordersRepository
     * @param UserRepositoryInterface $userRepository
     * @param BagsRepositoryInterface $bagsRepository
     * @param MailSenderInterface $mailer
     * @param AcceptDeclineOrder $validation
     * @return mixed
     */
    public function acceptOrder(
        OrdersRepositoryInterface $ordersRepository,
        UserRepositoryInterface $userRepository,
        BagsRepositoryInterface $bagsRepository,
        MailSenderInterface $mailer,
        AcceptDeclineOrder $validation
    ) {
        // Получение экземпляра заказа
        $order_id = $this->request->input('order_id');
        $order = $ordersRepository->getFirstOrNull($order_id);

        // Получение экземпляра товара
        $bag = $bagsRepository->getFirstOrNull($order->bag_id);

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
            return $this->withRedirectAndFlash(
                'status_failed',
                'Order accept with id $order_id failed',
                route('admin.orders'),
                $this->request
            );
        }

        // Отправка чека на почту пользователя
        $mail = new OrderReceipt($receipt->order_number);
        $mailer->queue($mail, $userRepository->getAuthenticated()?->email);

        return $this->withRedirectAndFlash(
            'status_success',
            'Order accept success',
            route('admin.orders'),
            $this->request
        );
    }
}
