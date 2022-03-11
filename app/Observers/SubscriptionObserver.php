<?php

namespace App\Observers;

use App\Http\Controllers\crud\SubscriptionController;
use App\Mail\BuyProduct;
use App\Mail\ProductInStock;
use App\Models\Bag;
use App\Services\interfaces\MailSenderInterface;
use App\Services\interfaces\SubscribeRepositoryInterface;
use Illuminate\Support\Facades\Mail;

class SubscriptionObserver
{
    public function updating(Bag $bag)
    {
        app()->call([$this, 'updatingWithDI'], ['bag' => $bag]);
    }

    public function updatingWithDI(
        Bag $bag,
        SubscribeRepositoryInterface $subscribeRepository,
        SubscriptionController $subController,
        MailSenderInterface $mailer
    )
    {
        $oldCount = $bag->getOriginal('count');

        if ($oldCount == 0 && $bag->count > 0) {
            $subscriptions = $subscribeRepository->getAllSubscriptionsByBag($bag->id);

            foreach ($subscriptions as $sub) {
                $mail = new BuyProduct($bag);
                $mailer->queue($mail, $sub->user->email);
            }

            $subController->deleteAllByBagId($bag->id);
        }
    }
}
