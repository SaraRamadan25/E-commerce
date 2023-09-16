<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\Product;
use App\Models\State;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Stripe\Exception\CardException;
use Stripe\StripeClient;


class CheckoutController extends Controller
{
    public function index(): View|Application|Factory
    {
        $products = Product::all();
        $subtotal = Cart::subtotal();
        $countries = Country::all();
        $states = State::all();
        $cities = City::all();
        return view('checkout.index',compact('products','subtotal','countries','states','cities'));
    }

    public function store(CheckoutRequest $request): RedirectResponse
    {
        $contents = Cart::content()->map(function ($item) {
            return $item->model->name.','.$item->qty;
        })->values()->toJson();

        try {
            $stripe = new StripeClient(env('STRIPE_SECRET'));

            $stripe->paymentIntents->create([
                'amount' => (Cart::total() * 100),
                'currency' => 'usd',
                'payment_method' => $request->payment_method,
                'description' => 'Demo payment with stripe',
                'confirm' => true,
                'receipt_email' => $request->email,
                'metadata' => [
                    'contents' => $contents,
                    'quantity' => Cart::instance('default')->count(),
                ],
            ]);

            Cart::instance('default')->destroy();

            return redirect()->route('confirmation.index')->with('message',
                'Thank You! Your payment has been successfully accepted!');

        } catch (CardException $e) {
            return back()->withErrors('Error! '.$e->getMessage());
        }

    }
}
