<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmation;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Services\CartService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Display the checkout page.
     */
    public function index()
    {
        if (Cart::count() == 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $countries = Country::all();
        $states = State::all();
        $cities = City::all();

        $numbers = $this->cartService->getNumbers();

        return view('checkout.index')->with([
            'countries' => $countries,
            'states' => $states,
            'cities' => $cities,
            'discount' => $numbers->get('discount'),
            'newSubtotal' => $numbers->get('newSubtotal'),
            'newTax' => $numbers->get('newTax'),
            'newTotal' => $numbers->get('newTotal'),
        ]);
    }


    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'payment_method' => 'required|string',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $numbers = $this->cartService->getNumbers();
        $amount = (int)($numbers->get('newTotal') * 100);

        $paymentMethodId = $request->input('payment_method');

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $amount,
                'currency' => 'usd',
                'payment_method' => $paymentMethodId,
                'confirmation_method' => 'manual',
                'confirm' => true,
            ]);

            if ($paymentIntent->status === 'succeeded') {
                $this->processOrder($request);
                Cart::destroy();

                return redirect()->route('confirmation.index')->with('message', 'Payment successful!');
            } else {
                return redirect()->route('checkout.index')->with('error', 'Payment was not successful, please try again.');
            }
        } catch (\Exception $e) {
            return redirect()->route('checkout.index')->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }


    private function processOrder(Request $request): void
    {
        $cartItems = Cart::content();
        $orderDetails = [];
        $totalQuantity = 0;

        foreach ($cartItems as $item) {
            $orderDetails[] = [
                'content' => $item->name,
                'quantity' => $item->qty,
            ];
            $totalQuantity += $item->qty;
        }

        $orderDetails[] = ['content' => 'Customer Name', 'quantity' => $request->input('name')];
        $orderDetails[] = ['content' => 'Customer Email', 'quantity' => $request->input('email')];
        $orderDetails[] = ['content' => 'Total', 'quantity' => Cart::total()];

        Mail::to($request->input('email'))->send(new OrderConfirmation($orderDetails, $totalQuantity, Cart::total()));
    }
}
