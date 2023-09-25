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
    public function store(ReviewRequest $request, $product_id): RedirectResponse
    {
        $request['user_id'] = auth()->user()->id;
        $request['product_id'] = $product_id;
        Review::create($request->all());
        return redirect()->back()->with('success','Review Added Successfully');

    }
    public function show (Product $product): View|Application|Factory
    {
        $reviews = $product->reviews()->take(5)->get();
        return view('products.show',compact('product','reviews'));
    }
}
