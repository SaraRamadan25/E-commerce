<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $coupon = Coupon::where('code', $request->code)->first();

        if (!$coupon)
        {
            return back()->withErrors(['coupon_code' => 'Invalid coupon code. Please try again.']);
        }

        session()->put('coupon', [
            'name' => $coupon->code,
            'discount' => $coupon->discount(Cart::subtotal()),
        ]);

        return redirect()->route('checkout.index')->with('success_message', 'Coupon has been applied!');
    }


    public function destroy(): RedirectResponse
    {
        session()->forget('coupon');
        return back()->with('success_message', 'Coupon has been removed.');
    }
}
