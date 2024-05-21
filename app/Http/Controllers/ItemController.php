<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemStoreRequest;
use App\Models\Category;
use App\Models\Item;
use App\Models\BestSellingItems;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index()
    {
        $menus = Item::all();

        return view('menus.index', compact('menus'));
    }
    public function indexAdmin()
    {
        $Items = Item::all();
        return view('admin.items.index', compact('Items'));
    }
    public function createAdmin()
    {
        $categories = Category::all();
        return view('admin.items.create', compact('categories'));
    }
    public function storeAdmin()
    {
        $category_id = request()->categories[0];
        $image = request()->file('image')->store('public/menus');
        $Item = Item::create([
            'name' => request()->name,
            'description' => request()->description,
            'image' => $image,
            'price' => request()->price,
            'category_id' =>$category_id
        ]);
        BestSellingItems::create([
            'item_id' =>$Item->id,
            'sales_volume' => 0
        ]);

        return redirect()->route('notify', ['item' => $Item->id]);
    }

    public function editAdmin()
    {
        $itemId =request()->id;
        $item = Item::findOrFail($itemId);
        $categories = Category::all();
        return view('admin.items.edit', compact('item', 'categories'));
    }
    public function updateAdmin()
    {
        $request = request();
        $itemId =request()->id;
        $item = Item::findOrFail($itemId);
        $image = $item->image;
        if ($request->hasFile('image')) {
            Storage::delete($item->image);
            $image = $request->file('image')->store('public/menus');
        }
        $single = $request->categories[0];
        $item->update([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $image,
            'price' => $request->price,
            'category_id' =>$single
        ]);
        return to_route('admin.items.index')->with('success', 'Item updated successfully.');
    }
    public function destroyAdmin()
    {
        $itemId =request()->id;
        $item = Item::findOrFail($itemId);
        Storage::delete($item->image);
        $item->delete();
        return to_route('admin.items.index')->with('danger', 'Item deleted successfully.');
    }
}
//
