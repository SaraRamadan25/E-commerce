<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\ExpressCheckout;
use Gloudemans\Shoppingcart\Facades\Cart;

class PaypalController extends Controller
{
    public function payment(Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $cartItems = Cart::content();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $items = [];
        $total = 0;
        foreach ($cartItems as $item) {
            $items[] = [
                'name' => $item->name,
                'price' => $item->price,
                'qty' => $item->qty,
            ];
            $total += $item->price * $item->qty;
        }

        $data = [
            'items' => $items,
            'invoice_id' => 1,
            'invoice_description' => "Order #1 Invoice",
            'return_url' => route('payment.success'),
            'cancel_url' => route('payment.cancel'),
            'total' => $total,
        ];

        $provider = new ExpressCheckout;
        $response = $provider->setExpressCheckout($data);

        if (strtoupper($response['ACK']) === 'SUCCESS') {
            return redirect($response['paypal_link']);
        } else {
            return redirect()->route('cart.index')->with('error', 'Something went wrong: ' . $response['L_LONGMESSAGE0']);
        }
    }

    public function cancel(): \Illuminate\Http\JsonResponse
    {
        return response()->json('Your payment is canceled. You can create a cancel page here.');
    }

    public function success(Request $request)
    {
        if (!$request->has('token')) {
            return response()->json('Missing token in the URL.');
        }

        $provider = new ExpressCheckout;

        $response = $provider->getExpressCheckoutDetails($request->token);

        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            return response()->json('Paid successfully.');
        } else {
            return response()->json('Something went wrong: ' . $response['L_LONGMESSAGE0']);
        }
    }
}
