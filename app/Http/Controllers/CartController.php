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
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory
    {
        return view('cart.index')->with([
            'discount' => $this->getNumbers()->get('discount'),
            'newSubtotal' => $this->getNumbers()->get('newSubtotal'),
            'newTax' => $this->getNumbers()->get('newTax'),
            'newTotal' => $this->getNumbers()->get('newTotal'),
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

        Cart::add(
            $productId,
            $productName,
            $quantity,
            $productPrice
        )->associate(Product::class);

        return redirect()->route('cart.index')->with('success', 'Successfully added to cart');
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
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        // Update cart item quantity
        Cart::update($id, $request->quantity);

        // Calculate updated values
        $subtotal = (float) Cart::subtotal(false, false, false); // Ensure it's a float
        $discount = session()->has('coupon') ? (float) session()->get('coupon')['discount'] : 0;
        $newSubtotal = max(0, $subtotal - $discount);  // Ensure no negative subtotal
        $taxRate = config('cart.tax') / 100;
        $newTax = $newSubtotal * $taxRate;
        $newTotal = $newSubtotal + $newTax;

        return response()->json([
            'success' => true,
            'subtotal' => number_format($subtotal, 2),
            'discount' => number_format($discount, 2),
            'newSubtotal' => number_format($newSubtotal, 2),
            'newTax' => number_format($newTax, 2),
            'newTotal' => number_format($newTotal, 2)
        ]);
    }

    private function getNumbers(): Collection
    {
        $tax = config('cart.tax') / 100;

        $discount = session()->get('coupon')['discount'] ?? 0;
        $discount = is_numeric($discount) ? (float) $discount : 0;

        // Ensure subtotal is a numeric value
        $subtotal = (float) str_replace(['$', ','], '', Cart::subtotal());
        $newSubtotal = $subtotal - $discount;

        $newTax = $newSubtotal * $tax;
        $newTotal = $newSubtotal + $newTax;

        return collect([
            'tax' => $tax,
            'discount' => $discount,
            'newSubtotal' => $newSubtotal,
            'newTax' => $newTax,
            'newTotal' => $newTotal,
        ]);
    }

    public function showCartSummary(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $taxRate = config('cart.tax') / 100;
        $discount = session()->get('coupon')['discount'] ?? 0;

        $subtotal = Cart::subtotal(false, false, false);
        $newSubtotal = $subtotal - $discount;
        $newTax = $newSubtotal * $taxRate;
        $newTotal = $newSubtotal + $newTax;

        return view('cart.index', [
            'subtotal' => $subtotal,
            'newSubtotal' => $newSubtotal,
            'newTax' => $newTax,
            'newTotal' => $newTotal,
            'discount' => $discount
        ]);
    }

}
