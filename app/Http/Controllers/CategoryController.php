<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Models\Category;
use App\Models\Item;
use App\Http\Objects\CategoryObject;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    private $CategoryObjects = [];

    public function getAllCategory()
    {
        $Categorys = Category::all();
        foreach ($Categorys as $Category) {
         $this->CategoryObjects[] = new CategoryObject($Category);
        }
        return $this->CategoryObjects;
    }
    public function index()
    {
        $categories = $this->getAllCategory();
        return view('categories.index', compact('categories'));
    }
    public function indexAdmin()
    {
        $categories = $this->getAllCategory();
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
        $categories = $this->getAllCategory();
        foreach ($categories as $category) {
            if($category->getId() == $categoryId) {
                return view('admin.categories.edit', compact('category'));
            }
        }

        return Redirect()->back()->with('danger', 'Category not found');
    }
    public function storeAdmin(CategoryStoreRequest $request)
    {
        $image = $request->file('image')->store('public/categories');

        $category = Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $image
        ]);
        $this->CategoryObjects[] = new CategoryObject($category);
        return to_route('admin.categories.index')->with('success', 'Category created successfully.');
    }
    public function updateAdmin()
    {
        $request = request();
        $categoryId =request()->id;
        $categories = $this->getAllCategory();
        $image = NULL;
        if ($request->hasFile('image')){
            $image =$request->file('image')->store('public/menus');
        }

        foreach($categories as $category)
        {
            if($category->getId()== $categoryId)
            {
                $isSucc = $category->updateCategory($request->name ,$request->description, $image);
                if($isSucc)
                {
                    return to_route('admin.categories.index')->with('success', 'Category updated successfully.');

                }else{
                    break;
                }
            }
        }

        return Redirect()->back()->with('danger', 'no Category found');
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
        $Items = Item::where('category_id', $category)->get();
        return view('categories.show', ['category'=>$Items]);
    }
}
