<?php

namespace App\Http\Controllers\Client;

use App\Events\OrderCreated;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function handleFormClient(Request $request)
    {
        if (Auth::check()) {
            $dataUser = [

                'user_id' => Auth::user()->id,
                'name' => Auth::user()->name,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
                'email' => Auth::user()->email,
            ];
        } else {
            // Người chưa đăng nhập
            $dataUser = [
                'name' => $request->guest_name,
                'address' => $request->guest_address,
                'phone_number' => $request->guest_phone_number,
                'email' => $request->guest_email,
            ];
        }
        return $dataUser;
    }

    public function addBuyNow(Request $request)
    {
        $dataUser = $this->handleFormClient($request);
        $dataItem = [
            'product_id' => $request['product_id'],
            'product_name' => $request['product_name'],
            'img_thumbnail' => $request['img_thumbnail'],
            'price_regular' => $request['price_regular'],
            'price_sale' => $request['price_sale'],
            'quantity' => $request['quantity_item'],
            'size_name' => $request['size_name'],
            'size_id' => $request['size_id'],
        ];
        



        try {
            DB::beginTransaction();

            if (!Auth::check()) {
                // Nếu không đăng nhập mà mua hàng, thì tạo 1 tài khoản
                // cho người dùng với trạng thái is_active = false;
                $guest = User::create([
                    'name' => $dataUser['name'],
                    'email' => $dataUser['email'],
                    'type' => "member",
                    'is_active' => false,
                    'password' => bcrypt($dataUser['email'])
                ]);
                $dataUser['user_id'] = $guest->id;
                Auth::login($guest);
            }
            // Tạo ra mã đơn hàng
            $dataUser['order_code'] = uniqid();
            // Tạo mới đơn hàng
            $order = Order::create($dataUser);
            $dataItem['order_id'] = $order->id;
            OrderItem::create($dataItem);

            event(new OrderCreated($dataUser, [$dataItem]));

            DB::commit();

            return redirect()->route('client.orders')->with("success", " Bạn đã đặt hàng thành công");
        } catch (\Exception $e) {
            return "Có lỗi: " . $e->getMessage();
        }
    }
    public function addOrder(Request $request)
    {
        $cart = session('cart');

        $dataUser = $this->handleFormClient($request);

        // Dữ liệu sản phẩm mua
        $dataItem  = [];
        foreach ($cart as $item) {
            $dataItem[] = [
                'product_id' => $item['id'],
                'product_name' => $item['name'],
                'img_thumbnail' => $item['img_thumbnail'],
                'price_regular' => $item['price_regular'],
                'price_sale' => $item['price_sale'],
                'quantity' => $item['quantity_item'],
                'size_name' => $item['size']['name'],
                'size_id' => $item['size']['id'],
            ];
        }
        try {
            DB::beginTransaction();

            if (!Auth::check()) {
                // Nếu không đăng nhập mà mua hàng, thì tạo 1 tài khoản
                // cho người dùng với trạng thái is_active = false;
                $guest = User::create([
                    'name' => $dataUser['name'],
                    'email' => $dataUser['email'],
                    'type' => "member",
                    'is_active' => false,
                    'password' => bcrypt($dataUser['email'])
                ]);
                $dataUser['user_id'] = $guest->id;
                Auth::login($guest);
            }
            // Tạo ra mã đơn hàng
            $dataUser['order_code'] = uniqid();
            // Tạo mới đơn hàng
            $order = Order::create($dataUser);
            // Duyệt qua các item của cart và thêm vào data
            foreach ($dataItem as $item) {
                $item['order_id'] = $order->id;
                OrderItem::create($item);
            }
            event(new OrderCreated($dataUser, $dataItem));

            //Xoá cart khi đã hoàn thành đơn hàng
            session()->forget('cart');
            DB::commit();

            return redirect()->route('client.orders')->with("success", " Bạn đã đặt hàng thành công");
        } catch (\Exception $e) {
            DB::rollBack();
            return "Có lỗi: " . $e->getMessage();
        }
    }

    public function orderCanceled($id)
    {
        $order = Order::findOrFail($id);
        if($order->status_order == "Chờ xác nhận"){
            $order->status_order = Order::STATUS_ORDER_CANCELED;
            $order->save();
            return redirect()->route('client.orderDetail', ['id' => $id])->with("success", "Huỷ đơn hàng thành công");
        }else{
            return redirect()->route('client.orderDetail', ['id' => $id])->with("error", "Bạn không thể huỷ đơn hàng này");
        }
    }
}
