<?php

namespace App\Services\Repositories;

use App\Models\Subscription;
use App\Services\interfaces\SubscribeRepositoryInterface;

class SubscribeRepository implements SubscribeRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function userIsSubscribed(int $user_id, int $bag_id)
    {
        return Subscription::where([['user_id', '=', $user_id], ['bag_id', '=', $bag_id]])->exists();
    }

    /**
     * @inheritDoc
     */
    public function getAllSubscriptionsByBag(int $bag_id)
    {
        return Subscription::with(['user'])->where([['bag_id', '=', $bag_id]])->get();
    }
}
