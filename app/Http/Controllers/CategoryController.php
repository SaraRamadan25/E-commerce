<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(5);
        return view('categories.index', compact('categories'));
    }

    public function show(Category $category){
        $products = $category->products()->get();
        return view('categories.show', compact('category','products'));
    }
}
