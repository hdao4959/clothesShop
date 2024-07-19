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

    public function orderUpdate(Request $request, string $id){
        $order = Order::findOrFail($id);
        $order->status_order = $request->status_order;
        $order->save();
        return redirect()->route('admin.order.detail', ['id' => $id])->with('success', 'Cập nhật trạng thái đơn hàng thành công');
    }

   
}
