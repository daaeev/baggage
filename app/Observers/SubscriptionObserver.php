<?php

namespace App\Observers;

use App\Http\Controllers\crud\SubscriptionController;
use App\Mail\BuyProduct;
use App\Models\Bag;
use App\Services\interfaces\MailSenderInterface;
use App\Services\interfaces\SubscribeRepositoryInterface;

class SubscriptionObserver
{
    public function updating(Bag $bag)
    {
        // Перенаправление на метод с использованием DI
        app()->call([$this, 'updatingWithDI'], ['bag' => $bag]);
    }

    public function updatingWithDI(
        Bag $bag,
        SubscribeRepositoryInterface $subscribeRepository,
        SubscriptionController $subController,
        MailSenderInterface $mailer
    )
    {
        // Получение значения до изменения продукта
        $oldCount = $bag->getOriginal('count');

        // Если продукта не было в наличии, но он появился
        if ($oldCount == 0 && $bag->count > 0) {

            // Получить все подписки на товар
            $subscriptions = $subscribeRepository->getAllSubscriptionsByBag($bag->id);

            foreach ($subscriptions as $sub) {

                // Отправка почты
                $mail = new BuyProduct($bag);
                $mailer->queue($mail, $sub->user->email);
            }

            // Удаление подписок
            $subController->deleteAllByBagId($bag->id);
        }
    }
}
