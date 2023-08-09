<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $products = Product::query();

        if ($request->has('size')) {
            $products->where('size', $request->input('size'));
        }

        if ($request->has('color')) {
            $products->where('color', $request->input('color'));
        }

        if ($request->has('min_price')) {
            $products->where('price', '>=', $request->input('min_price'));
        }

        if ($request->has('max_price')) {
            $products->where('price', '<=', $request->input('max_price'));
        }

        $filteredProducts = $products->get();

        return view('shop.index', compact('filteredProducts'));
    }
}
