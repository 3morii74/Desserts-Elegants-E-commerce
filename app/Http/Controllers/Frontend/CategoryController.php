<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function show($category)
    {
        // @dd($category);
        $Items = Item::where('category_id', $category)->get();
        return view('categories.show', ['category'=>$Items]);
    }
}
