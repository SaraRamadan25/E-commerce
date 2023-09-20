<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Mail\OrderConfirmation;
use App\Models\City;
use App\Models\Country;
use App\Models\Product;
use App\Models\State;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Mail;



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
    public function store(CheckoutRequest $request): View|Application|Factory
    {
        $cartContents = Cart::content();

        $orderDetails = [];
        foreach ($cartContents as $item) {
            $orderDetails[] = [
                'content' => $item->name,
                'quantity' => $item->qty,
            ];
        }

        Mail::to($request->email)->send(new OrderConfirmation($orderDetails));

        return view('thankyou', compact('orderDetails'));
    }    }
