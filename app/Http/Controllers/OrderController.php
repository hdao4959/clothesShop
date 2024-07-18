<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function addOrder(Request $request)
    {
        $cart = session('cart');

        // Dữ liệu của người dùng
        $dataUser = [
            'name' => $request->name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
        ];

        // Dữ liệu sản phẩm mua
        $dataItem  = [];
        foreach ($cart as $item) {
            $dataItem[] = [
                'product_name' => $item['name'],
                'img_thumbnail' => $item['img_thumbnail'],
                'price_regular' => $item['price_regular'],
                'price_sale' => $item['price_sale'],
                'quantity' => $item['quantity'],
                'size_name' => $item['size']['name'],
            ];
        }



        try {
            DB::beginTransaction();


            $order = Order::create($dataUser);
            foreach ($dataItem as $item) {
                $item['order_id'] = $order->id;
                OrderItem::create($item);
            }

            session()->forget('cart');
            DB::commit();

            return redirect()->route('cart');
        } catch (\Exception $e) {
            DB::rollBack();
            return "Có lỗi: " . $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
