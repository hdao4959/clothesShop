<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function showCart()
    {
        $products = Product::limit(2)->get();
        return view('client.cart', compact('products'));
    }

    public function handleCart(Request $request)
    {
        $action = $request->input('action');
        if ($action == 'add_to_cart') {
            return $this->addCart($request);
        }
        if ($action == 'buy_now') {
            return $this->buyNow($request);
        }
    }


    public function buyNow(Request $request)
    {
        $product_id = $request->product_id;
        $size_id = $request->size;
        $quantity_item = $request->quantity_item;
        return redirect()->route('form_buy_now', [
            'product_id' => $product_id,
            'size_id' => $size_id,
            'quantity_item' => $quantity_item
        ]);
        // $product = Product::findOrFail($request->product_id);
        // $variant = ProductVariant::with('size')->where([
        //     ['product_id', $request->product_id],
        //     ['product_size_id', $request->size]
        // ])->firstOrFail();
        // // Gom thông tin của sản phẩm và biến thể, số lượng 
        // $data = $product->toArray() + $variant->toArray();
        // return $this->showFormOrder($data);


    }
    public function addCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $variant = ProductVariant::with('size')->where([
            ['product_id', $request->product_id],
            ['product_size_id', $request->size]
        ])->firstOrFail();


        $cart = session()->get('cart', []);

        if (isset($cart) && isset($cart[$variant->id])) {
            $cart[$variant->id]['quantity_item'] += $request->quantity_item;
        } else {
            $data = $product->toArray() + $variant->toArray()
                + ['quantity_item' => $request->quantity_item];
            $cart[$variant->id] = $data;
        }
        session()->put('cart', $cart);


        return redirect()->route('cart');
    }


    public function removeItem($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            return redirect()->route('cart')->with('success', "Xoá sản phẩm khỏi giỏ hàng thành công");
        }

        // Chuyển hướng về trang giỏ hàng sau khi xoá thành công
        return redirect()->route('cart');
    }


    public function showFormOrder(Request $request)
    {
        
        $cart = session('cart');
        return view('client.form-order', compact('cart'));
    }

    public function showFormBuyNow(Request $request)
    {
        // Trường hợp người dùng mua ngay 
        $product_id = $request->product_id;
        $size_id = $request->size_id;
        $quantity_item = $request->quantity_item;
        $dataProduct = Product::findOrFail($product_id)->toArray();
        $dataVariant = ProductVariant::where([
            ['product_id', $product_id],
            ['product_size_id', $size_id]
        ])->with('size')->first();
        $size_name = $dataVariant->size->name;
        $sizeAndQuantity = [
            'size_name' => $size_name,
            'quantity_item' => $quantity_item
        ];
        $dataProduct['size_id'] = $size_id;
        $dataProduct = array_merge($dataProduct, $sizeAndQuantity);
        return view('client.form_buy_now', compact('dataProduct'));

    }
}
