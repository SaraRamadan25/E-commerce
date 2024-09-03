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
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function index(): View|Application|Factory
    {
        $countries = Country::all();
        $states = State::all();
        $cities = City::all();

        return view('checkout.index')->with([
            'countries' => $countries,
            'states' => $states,
            'cities' => $cities,
            'discount' => $this->getNumbers()->get('discount'),
            'newSubtotal' => $this->getNumbers()->get('newSubtotal'),
            'newTax' => $this->getNumbers()->get('newTax'),
            'newTotal' => $this->getNumbers()->get('newTotal'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $total = Cart::total();
        $numericTotal = preg_replace('/[^\d.]/', '', $total);
        $amount = (int)($numericTotal * 100);

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

                Cart::destroy();

                $orderDetails[] = [
                    'content' => 'Customer Name',
                    'quantity' => $request->input('name'),
                ];

                $orderDetails[] = [
                    'content' => 'Customer Email',
                    'quantity' => $request->input('email'),
                ];

                $orderDetails[] = [
                    'content' => 'Total',
                    'quantity' => $total,
                ];

                Mail::to($request->input('email'))->send(new OrderConfirmation($orderDetails, $totalQuantity, $total));

                return redirect()->route('confirmation.index')->with('message', 'Payment successful!');
            } else {
                return redirect()->route('checkout.index')->with('error', 'Payment was not successful, please try again.');
            }
        } catch (\Exception $e) {
            return redirect()->route('checkout.index')->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }    private function calculateTax($subtotal): float
    {
        return $subtotal * 0.1;
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

}
