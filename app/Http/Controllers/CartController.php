<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory
    {
        $products = Product::all();
        return view('cart.index', compact('products'));
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        $product = Product::findOrFail($request->input('id'));

        Cart::add(
            $product->id,
            $product->name,
            1,
            $product->price_after_offer,
        )->associate('App\Models\Product');

        return redirect()->route('cart.index')->with('message', 'Successfully added');
    }

    public function destroy($id): RedirectResponse
    {
        Cart::remove($id);
        return back()->with('success_message', 'Item has been removed from your cart!');
    }

    public function update(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|between:1,5'
        ]);
        if ($validator->fails()) {
            session()->flash('errors', collect(['Quantity must be between 1 and 5.']));
            return response()->json(['success' => false], 400);
        }

        Cart::update($id, $request->quantity);
        session()->flash('success_message', 'Quantity updated successfully!');
        return response()->json(['success' => true]);
    }
}
