<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Contracts\Mail\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(): View|Application|Factory
    {
        $categories = Category::paginate(5);
        return view('categories.index', compact('categories'));
    }

    public function show($slug): View|Application|Factory
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = $category->products()->get();

        return view('categories.show', compact('category','products'));
    }
}
