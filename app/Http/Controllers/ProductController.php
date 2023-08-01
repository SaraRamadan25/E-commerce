<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        $cart = Cart::all();
        return view('products.index',compact('products','cart'));
    }

    public function show(Product $product){

        return view('products.show', compact('product'));
    }
}
