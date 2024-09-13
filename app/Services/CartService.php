<?php

namespace App\Services;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Collection;

class CartService
{
    public function getNumbers(): Collection
    {
        $tax = config('cart.tax') / 100;
        $discount = session()->get('coupon')['discount'] ?? 0;
        $discount = is_numeric($discount) ? (float) $discount : 0;

        $subtotal = (float) str_replace(['$', ','], '', Cart::subtotal());

        $newSubtotal = max(0, $subtotal - $discount);

        $newTax = $newSubtotal * $tax;

        $newTotal = $newSubtotal + $newTax;

        return collect([
            'discount' => $discount,
            'subtotal' => $subtotal,
            'newSubtotal' => $newSubtotal,
            'newTax' => $newTax,
            'newTotal' => $newTotal,
        ]);
    }
}
