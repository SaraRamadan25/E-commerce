<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index(): \Illuminate\Contracts\Foundation\Application|Factory|View|Application
    {
        $user = Auth::user();
        $reviews = $user->reviews()->with('product', 'user')->get();

        $formattedReviews = [];

        foreach ($reviews as $review) {
            $formattedReviews[] = [
                'id' => $review->id,
                'rate' => $review->rate,
                'review' => $review->review,
                'productName' => $review->product->name,
                'OwnerName' => $review->product->owner->name,
                'Username' => $review->user->username,
            ];
        }
        return view('reviews.index', compact('formattedReviews'));
    }
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
