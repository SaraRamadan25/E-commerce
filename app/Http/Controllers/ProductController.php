<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(): View|Application|Factory
    {
        $products = Product::latest()
            ->filter(request(['search','category']))
            ->paginate(6);

        return view('products.index',compact('products'));
    }

    public function show(Product $product): View|Application|Factory
    {
        $products = Product::all();
        return view('products.show', compact('product','products'));
    }


}
