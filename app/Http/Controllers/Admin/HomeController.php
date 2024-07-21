<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalOrderes = Order::count();
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        return view('admin.home', compact('totalOrderes', 'totalProducts', 'totalCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
   

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

   
}
