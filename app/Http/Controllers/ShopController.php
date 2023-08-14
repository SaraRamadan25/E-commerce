<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request): View|Application|Factory
    {
        $priceRanges = [
            ['min' => 0, 'max' => 100],
            ['min' => 100, 'max' => 200],
            ['min' => 200, 'max' => 300],
            ['min' => 300, 'max' => 400],
            ['min' => 400, 'max' => 500],
        ];

        $colors = [
            'red', 'blue', 'green', 'yellow', 'black', 'white'
        ];

        $sizes = [
            'small', 'medium', 'large', 'xlarge'
        ];

        $productsQuery = Product::query();

        if ($request->has('price')) {
            $priceFilter = $request->input('price');
        }


        $filteredProducts = $productsQuery->get();
        $productCountsByPriceRange = [];
        foreach ($priceRanges as $range)
        {
            $count = $filteredProducts->whereBetween('price_after_offer', [$range['min'], $range['max']])->count();
            $productCountsByPriceRange[] = ['range' => $range, 'count' => $count];
        }

        $products = $productsQuery->paginate(9);

        return view('shop.index', compact('products', 'priceRanges', 'productCountsByPriceRange', 'colors','sizes'));
    }
}
