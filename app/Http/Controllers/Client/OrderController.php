<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        // Người đã đăng nhập
        if(Auth::check()){
            $dataUser = [
                
                'user_id' => Auth::user()->id,
                'name' => Auth::user()->name,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
                'email' => Auth::user()->email,
            ];
        }else{
            // Người chưa đăng nhập
            $dataUser = [
                'name' => $request->guest_name,
                'address' => $request->guest_address,
                'phone_number' => $request->guest_phone_number,
                'email' => $request->guest_email,
            ];
        }
        // dd($dataUser);

        // Dữ liệu sản phẩm mua
        $dataItem  = [];
        foreach ($cart as $item) {
            $dataItem[] = [
                'product_name' => $item['name'],
                'img_thumbnail' => $item['img_thumbnail'],
                'price_regular' => $item['price_regular'],
                'price_sale' => $item['price_sale'],
                'quantity' => $item['quantity_item'],
                'size_name' => $item['size']['name'],
            ];
        }

        try {
            DB::beginTransaction();

            if(!Auth::check()){
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

            //Xoá cart khi đã hoàn thành đơn hàng
            session()->forget('cart');
            DB::commit();

            return redirect()->route('client.orders')->with("success", " Bạn đã đặt hàng thành công");
        } catch (\Exception $e) {
            DB::rollBack();
            return "Có lỗi: " . $e->getMessage();
        }
    }

    public function orderCanceled($id){
        $order = Order::find($id);
        $order->status_order = Order::STATUS_ORDER_CANCELED;
        $order->save();
        return redirect()->route('client.orderDetail',['id' => $id])->with("success", "Huỷ đơn hàng thành công");
    }


}
