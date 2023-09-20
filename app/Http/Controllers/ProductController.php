<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Mail\OrderConfirmation;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
        $maylike = Product::where('id','!=',$product->id)->inRandomOrder()->take(4)->get();
        $products = Product::all();
        return view('products.show', compact('product','products','maylike'));
    }


}
