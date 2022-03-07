<?php

namespace App\Http\Controllers\crud;

use App\Http\Controllers\Controller;
use App\Services\interfaces\OrdersRepositoryInterface;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function declineOrder(Request $request, OrdersRepositoryInterface $ordersRepository)
    {
        $request->validate([
            'order_id' => 'required|exists:\App\Models\Order,id',
        ]);

        $order_id = $request->input('order_id');
        $order = $ordersRepository->getFistOrNull($order_id);

        if (!$order->delete()) {
            $request->session()->flash('status_failed', "Order decline with id $order_id failed");

            return redirect(route('admin.orders'));
        }

        $request->session()->flash('status_success', "Order decline success");

        return redirect(route('admin.orders'));
    }
}
