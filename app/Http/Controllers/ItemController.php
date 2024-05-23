<?php

namespace App\Http\Controllers;
use App\Http\Objects\ItemObject;
use App\Http\Controllers\Controller;
use App\Http\Requests\ItemStoreRequest;
use App\Models\Category;
use App\Models\Item;
use App\Models\BestSellingItems;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    private $itemObjects = [];

    public function getAllItems()
    {
        $items = Item::all();
        foreach ($items as $item) {
         $this->itemObjects[] = new ItemObject($item);
        }
        return $this->itemObjects;
    }
    public function getItem($id)
    {
        $items = $this->getAllItems();
        foreach ($items as $item) {
            if($item->getId() == $id) {
                return $item;
            }
        }
        return null;
    }
    public function indexAdmin()
    {
        $Items = $this->getAllItems();
        return view('admin.items.index', compact('Items'));
    }
    public function createAdmin()
    {
        $CategoryController = new CategoryController;
        $categories = $CategoryController->getallCategory();
        return view('admin.items.create', compact('categories'));
    }
    public function storeAdmin()
    {
        $category_id = request()->categories[0];
        if (!request()->hasFile('image') || !request()->file('image')->isValid()) {
            return back()->withErrors(['image' => 'The image file is required and must be valid.']);
        }
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
        $this->itemObjects[] = new ItemObject($Item);


        return redirect()->route('notify', ['item' => $Item->id]);
    }

    public function editAdmin()
    {
        $itemId =request()->id;
        // $item = Item::findOrFail($itemId);
        $Items = $this->getAllItems();
        $CategoryController = new CategoryController;
        $categories = $CategoryController->getallCategory();
        foreach($Items as $Item)
        {
            if($Item->getId() == $itemId)
            {
                return view('admin.items.edit', compact('Item', 'categories'));

            }
        }
        return Redirect()->back()->with('danger' , 'Item is not found');
    }
    public function updateAdmin()
    {
        $request = request();
        $itemId =request()->id;
        $single = $request->categories[0];
        $image = NULL;
        if ($request->hasFile('image')){
            $image =$request->file('image')->store('public/menus');
        }

        if($request->name == Null || $request->description == Null ||  $request->price == Null || $request->categories == Null)
        {
            return Redirect()->back()->with('danger', 'Fill all felids ');
        }


        $Items = $this->getAllItems();
        foreach($Items as $Item)
        {
            if($Item->getId() == $itemId)
            {
                $isSucc = $Item->updateItem($request->name , $request->description , $request->price , $single , $image);
                if($isSucc)
                {
                    return to_route('admin.items.index')->with('success', 'Item updated successfully.');

                }else{
                    break;
                }
            }
        }

        return Redirect()->back()->with('danger', 'no items found');

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
