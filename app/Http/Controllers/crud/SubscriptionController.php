<?php

namespace App\Http\Controllers\crud;

use App\Http\Controllers\Controller;
use App\Models\Subscription;

class SubscriptionController extends Controller
{
    public function deleteAllByBagId(int $bag_id)
    {
        Subscription::where([['bag_id', '=', $bag_id]])->delete();
    }
}
