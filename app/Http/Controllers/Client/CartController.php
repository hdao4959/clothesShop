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
        return redirect()->route('cart')->with('success', "Xoá sản phẩm khỏi giỏ hàng thành công thành công");

        }
        
        // Chuyển hướng về trang giỏ hàng sau khi xoá thành công
        return redirect()->route('cart');
    }


    public function showFormOrder(Request $request)
    {
        $products = Product::limit(2)->get();

        return view('client.form-order', compact('products'));
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

    public function destroy(string $id)
    {
        //
    }
}
