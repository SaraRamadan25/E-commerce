<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Checkout;
use App\Models\Product;
use Cartalyst\Stripe\Exception\CardErrorException;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class CheckoutController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $subtotal = Cart::subtotal();
        $countries = Checkout::pluck('country');
        $states = Checkout::pluck('state');
        $cities = Checkout::pluck('city');
        return view('checkout.index',compact('products','subtotal','countries','states','cities'));

    }

    public function store(CheckoutRequest $request): RedirectResponse
    {
        $contents = Cart::content()->map(function ($item) {
            return $item->model->slug.', '.$item->qty;
        })->values()->toJson();

        try
        {
            $charge = Stripe::charges()->create([
                'amount' => Cart::total() / 100,
                'currency' => 'CAD',
                'source' => $request->stripeToken,
                'description' => 'Order',
                'receipt_email' => $request->email,
                'metadata' => [
                    'contents' => $contents,
                    'quantity' => Cart::instance('default')->count(),
                ],
            ]);

            Cart::instance('default')->destroy();
            return redirect()->route('confirmation.index')->with('success_message', 'Thank you! Your payment has been successfully accepted!');
        } catch (CardErrorException $e) {
            return back()->withErrors('Error! ' . $e->getMessage());
        }

}
}
