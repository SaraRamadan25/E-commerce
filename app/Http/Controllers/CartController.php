<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('carts.index', compact('products'));
    }

    public function store(ProductRequest $request)
    {
        $product = Product::findOrFail($request->input('id'));
        Cart::add(
            $product->id,
            $product->name,
            $product->quantity,
            $product->price_after_offer / 100,
        )->associate('Product');

        return redirect()->route('products.index')->with('message', 'Successfully added');
    }

    public function destroy($id)
    {
        Cart::remove($id);
        return back()->with('success_message', 'Item has been removed from your cart!');
    }

    // Your other controller methods here...



}
