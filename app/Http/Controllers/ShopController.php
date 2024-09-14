<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;

class ShopController extends Controller
{
    public function index(): Factory|View|Application
    {
        $filteredProducts = Product::all();

        return view('shop.index', compact('filteredProducts'));
    }

    public function show(Product $product): View|Application|Factory
    {
        $products = Product::all();
        return view('products.show', compact('product', 'products'));
    }

    public function filter(Request $request): View|Application|Factory
    {
        $products = Product::query();

        if ($request->has('size')) {
            $products->where('size', $request->input('size'));
        }

        if ($request->has('color')) {
            $products->where('color', $request->input('color'));
        }

        $filteredProducts = $products->get();

            return view('shop.index', compact('filteredProducts'));
        }


}
