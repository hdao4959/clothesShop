<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        $orders = Order::paginate(5);
        return view('admin.orders.list', compact('orders'));
    }

    public function orderDetail( string $id)
    {
        $order = Order::findOrFail($id);
        $orderItems = $order->orderItems()->get();
        return view('admin.orders.detail', compact('order', 'orderItems'));
    }

    public function orderUpdate(){
        dd("àasfsa");
    }

   
}
