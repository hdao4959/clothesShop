<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $products = Product::where('is_active', true)->where('is_show_home', true)->paginate(5);
        return view('client.index', compact('products'));
    }


    public function detail(string $slug)
    {
        $product = Product::where('slug', $slug)->first();
        $galleries = $product->galleries->toArray();
        
        $sizes = $product->variants();
        // dd($sizes);
        return view('client.detail', compact('product', 'galleries', 'sizes'));
    }

    public function showCategory(string $id){
        $products = Product::where('category_id' , $id)->get();
        return view('client.category', compact('products'));
    }

}
