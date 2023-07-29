<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::inRandomOrder()->paginate(10);
        $featured_products = Product::where('rate', '>=', 3)->get();
        $recent_products = Product::latest()->get()->take(4);

        return view('index', compact('categories','featured_products','recent_products'));
    }
}
