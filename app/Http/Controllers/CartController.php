<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }


    public function index(): View|Application|Factory
    {
        $numbers = $this->cartService->getNumbers();

        return view('cart.index')->with([
            'discount' => $numbers->get('discount'),
            'newSubtotal' => $numbers->get('newSubtotal'),
            'newTax' => $numbers->get('newTax'),
            'newTotal' => $numbers->get('newTotal'),
        ]);
    }


    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'id' => 'required|integer|exists:products,id',
            'name' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
        ]);

        $productId = $request->input('id');
        $productName = $request->input('name');
        $productPrice = $request->input('price');
        $quantity = $request->input('quantity', 1);

        Cart::add($productId, $productName, $quantity, $productPrice)
            ->associate(Product::class);

        return redirect()->route('cart.index')->with('success', 'Successfully added to cart');
    }


    public function destroy($id): RedirectResponse
    {
        Cart::remove($id);
        return back()->with('success_message', 'Item has been removed from your cart!');
    }
}
