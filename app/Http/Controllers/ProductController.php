<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $products = Product::latest()->paginate(6);

        return view('products.index',compact('products'));
    }

    public function show(Product $product): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $products = Product::all();
        return view('products.show', compact('products','product'));
    }

   /* public function store(ProductRequest $request){
        $product = Product::findOrFail($request->input('id'));
        Cart::add(
            $product->id,
            $product->name,
            $product->quantity,
            $product->price_after_offer,
        )->associate('Product');
        return redirect()->route('products.index')->with('message', 'Successfully added');
    }*/
}
