<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function showByProductName(Request $request, string $productName): \Illuminate\Contracts\Foundation\Application|Factory|View|Application
    {
        $product = Product::where('name', $productName)->first();

        if (!$product) {
            return redirect()->route('home')->with('error', 'Product not found.');
        }

        $reviews = Review::with(['user', 'product.owner'])
            ->where('product_id', $product->id)
            ->get();

        $formattedReviews = collect();

        foreach ($reviews as $review) {
            $formattedReviews->push([
                'id' => $review->id,
                'rate' => $review->rate,
                'review' => $review->review,
                'productName' => $product->name,
                'Username' => $review->user->username,
                'OwnerName' => $product->owner->name ?? 'Unknown Owner',
            ]);
        }

        return view('reviews.index', compact('formattedReviews'));
    }
}
