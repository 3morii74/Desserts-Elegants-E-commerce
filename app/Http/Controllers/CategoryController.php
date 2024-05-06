<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Models\Category;
use App\Models\Item;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }
    public function indexAdmin()
    {
            $categories = Category::all();
            return view('admin.categories.index', compact('categories'));
        // return view('Home');
    }
    public function createAdmin()
    {
        return view('admin.categories.create');
    }
    public function editAdmin()
    {
        $categoryId =request()->id;
        $category = Category::findOrFail($categoryId);
        return view('admin.categories.edit', compact('category'));
    }
    public function storeAdmin(CategoryStoreRequest $request)
    {
        $image = $request->file('image')->store('public/categories');

        Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $image
        ]);

        return to_route('admin.categories.index')->with('success', 'Category created successfully.');
    }
    public function updateAdmin()
    {
        $request = request();
        $categoryId =request()->id;
        $category = Category::findOrFail($categoryId);

        $image = $category->image;
        if ($request->hasFile('image')) {
            Storage::delete($category->image);
            $image = $request->file('image')->store('public/categories');
        }

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $image
        ]);
        return to_route('admin.categories.index')->with('success', 'Category updated successfully.');
    }
    public function destroyAdmin()
    {
        $categoryId =request()->id;
        $category = Category::findOrFail($categoryId);
        Storage::delete($category->image);
        $items = Item::where('category_id' , $category->id)->delete();
        $category->delete();

        return to_route('admin.categories.index')->with('danger', 'Category deleted successfully.');
    }
    public function show($category)
    {
        // @dd($category);
        $Items = Item::where('category_id', $category)->get();
        return view('categories.show', ['category'=>$Items]);
    }
}
