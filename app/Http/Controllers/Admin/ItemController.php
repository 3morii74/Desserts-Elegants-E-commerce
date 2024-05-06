<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemStoreRequest;
use App\Models\Category;
use App\Models\Item;
use App\Models\BestSellingItems;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Item::all();
        return view('admin.menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.menus.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        // @dd(request()->all());
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

        // if ($request->has('categories')) {
        //     $menu->categories()->attach($request->categories);
        // }

        return to_route('admin.menus.index')->with('success', 'Item created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $menu)
    {
        $categories = Category::all();
        return view('admin.menus.edit', compact('menu', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $menu)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required'
        ]);
        $image = $menu->image;
        if ($request->hasFile('image')) {
            Storage::delete($menu->image);
            $image = $request->file('image')->store('public/menus');
        }
        // @dd($request->categories[0]);
        $single = $request->categories[0];
        $menu->update([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $image,
            'price' => $request->price,
            'category_id' =>$single
        ]);

        // if ($request->has('categories')) {
        //     $menu->categories()->sync($request->categories);
        // }
        return to_route('admin.menus.index')->with('success', 'Item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $menu)
    {
        Storage::delete($menu->image);

        $menu->delete();
        return to_route('admin.menus.index')->with('danger', 'Item deleted successfully.');
    }
}
