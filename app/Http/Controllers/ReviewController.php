<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $product_id): RedirectResponse
    {
        $request['user_id'] = 1;
        $request['product_id'] = $product_id;
        $request['rate'] = 5;
        Review::create($request->all());
return redirect()->back();
    }


    public function show (Product $product): View|Application|Factory
    {
        $reviews = $product->reviews()->take(5)->get();
        return view('products.show',compact('product','reviews'));
    }
}
