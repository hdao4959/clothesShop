<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accounts = User::paginate('5');
        return view('admin.accounts.index', compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     */


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $account = User::findOrFail($id);
        return view('admin.accounts.show', compact('account'));
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
        $account = User::findOrFail($id);
        $data = $request->all();
        $account->update($data);
        return redirect()->back()->with('success', "Cập nhật tài khoản thành công");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Auth::check() && Auth::user()->id == $id) {
            return redirect()->back()->with('error', 'Bạn không thể xóa tài khoản admin đang đăng nhập.');
        }
        DB::beginTransaction();

        try {
            // Tìm người dùng và các đơn hàng của người dùng đó
            $account = User::findOrFail($id);
            
            $orders = Order::with('orderItems')->where('user_id', $account->id)->get();

            // Lặp qua các đơn hàng và xóa các mục trong đơn hàng
            foreach ($orders as $order) {
                $order->orderItems()->delete(); // Xóa các mục trong đơn hàng
                $order->delete(); // Xóa đơn hàng
            }

            // Xóa người dùng
            $account->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Xoá tài khoản thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return "Có lỗi " . $e->getMessage();
        }
    }
}
