<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;

class ShopController extends Controller
{
    public function index(): Factory|View|Application
    {
        $products = Product::all();

        return view('shop.index', compact('products'));
    }
    public function show(Product $product): View|Application|Factory
    {
        $products = Product::all();
        return view('products.show', compact('product','products'));
    }

}
