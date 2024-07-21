<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $products = Product::where('is_active', true)->where('is_show_home', true)->paginate(5);
        $newProducts = Product::where([
            ['is_active', true],
            ['is_new', true],
            ['is_show_home', true]
        ])->orderBy('id', 'DESC')->limit(4)->get();
            

        $hotDealProducts = Product::where([
            ['is_active', true],
            ['is_hot_deal', true],
            ['is_show_home', true]
        ])->orderBy('id', 'DESC')->limit(4)->get();



        return view('client.index', compact('products', 'newProducts', 'hotDealProducts'));
    }


    public function detail(string $slug)
    {
        $product = Product::where('slug', $slug)->with('variants.size')->first();
        $galleries = $product->galleries;
        $category_id = $product->category->id;
       $other_products = Product::where([
        ['category_id' , $category_id],
        ['is_active', true],
        ['is_show_home', true]
       ])->where('id', "!=" , $product->id)->limit(4)->get();
        return view('client.detail', compact('product', 'galleries', 'other_products'));
    }

    public function showCategory(string $id)
    {
        $products = Product::where([
            ['category_id', $id],
            ['is_active', true]
        ])->get();
        return view('client.category', compact('products'));
    }

    public function account(){
        $account = User::find(Auth::user()->id);
        $orders = $account->orders;
        return view('client.orders', compact('orders'));
    }

    public function orderDetail($id){
        $account = User::find(Auth::user()->id);
        $orders  = $account->orders->first();
        $orderItems = $orders->orderItems;
       
        return view('client.orderDetail', compact('account', 'orders', 'orderItems'));
    }
}
