<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;

class CartController extends Controller
{
    /**
     * Add item to the cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addToCart()
    {
        // Validate the request data
        request()->validate([
            'menu_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        // Retrieve the authenticated user
        $user = Auth::user();
        $menu = Item::findOrFail(request()->menu_id);

        // Check if the item already exists in the user's cart
        $existingCartItem = CartItem::where('user_id', $user->id)
            ->where('item', $menu->name)
            ->first();

        if ($existingCartItem) {
            // If the item exists, increment its quantity and update the price
            $existingCartItem->quantity += request()->quantity;
            $existingCartItem->price = $menu->price * $existingCartItem->quantity; // Update the total price
            $existingCartItem->save();
        } else {
            // If the item does not exist, create a new cart item
            $cartItem = CartItem::create([
                'user_id' => $user->id,
                'category_id' => request()->category_id,
                'quantity' => request()->quantity,
                'item' => $menu->name, // Use the name of the menu item
                'price' => $menu->price * request()->quantity, // Calculate the total price
            ]);
        }

        // Optionally, you can return a response indicating success
        $category = request()->category_id;
        return redirect()->route('categories.show', ['category' => $category]);
    }

    /**
     * Display the user's cart.
     *
     * @return \Illuminate\Http\Response
     */
    public function showCart()
    {
        // Retrieve the authenticated user's cart items
        $user = Auth::user();
        $cartItems = CartItem::where('user_id', $user->id)->get();

        // Create an empty array to store unique items
        $uniqueItems = [];

        // Initialize the total price
        $totalPrice = 0;

        // Iterate over the cart items
        foreach ($cartItems as $cartItem) {
            // Retrieve the item details from the Item table
            $item = Item::where('name', $cartItem->item)->first();
            // Check if the item is already in the unique items array
            $existingItemIndex = array_search($item->name, array_column($uniqueItems, 'item'));

            if ($existingItemIndex !== false) {
                // If the item exists, increment its quantity
                $uniqueItems[$existingItemIndex]['quantity'] += $cartItem->quantity;
            } else {
                // If the item does not exist, add it to the unique items array
                $uniqueItems[] = [
                    'id' => $cartItem->id,
                    'quantity' => $cartItem->quantity, // Set initial quantity
                    'item' => $item->name,
                    'price' => $item->price,
                    'image' => $item->image, // Add image URL to the array
                    // Add other item properties as needed
                ];
            }

            // Update the total price
            $totalPrice += $item->price * $cartItem->quantity;
        }
        // @dd($uniqueItems);
        // Optionally, you can return a view to display the unique cart items along with the total price
        return view('cart.show', ['items' => $uniqueItems, 'subtotal' => $totalPrice]);
    }



    /**
     * Update the quantity of an item in the cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function decrementItem($item)
    {
        $user = Auth::user();

        $cartItem = CartItem::where('user_id', $user->id)
            ->where('item', $item)
            ->first();


        $itemObject = Item::where('name', $item)->first();

        $cartItem->update([
            'quantity' =>  $cartItem->quantity - 1,
            'price' => $cartItem->price - $itemObject->price, // Update the price based on the new quantity
        ]);

        return redirect()->route('item.show');
    }

    public function incrementItem($item)
    {
        $user = Auth::user();

        $cartItem = CartItem::where('user_id', $user->id)
            ->where('item', $item)
            ->first();

        $itemObject = Item::where('name', $item)->first();

        $cartItem->update([
            'quantity' =>  $cartItem->quantity + 1,
            'price' => $cartItem->price + $itemObject->price, // Update the price based on the new quantity
        ]);

        return redirect()->route('item.show');
    }


    /**
     * Remove an item from the cart.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function removeFromCart($item)
    {
        // Retrieve the cart item
        // Find all cart items with the same name
        $cartItemsToDelete = CartItem::where('item', $item)->get();

        // Delete all found cart items
        foreach ($cartItemsToDelete as $item) {
            $item->delete();
        }
        // Optionally, you can return a response indicating success
        return redirect()->route('item.show');
    }

    public function showCheckOut()
    {
        $totalPrice = request()->subtotal;
        $itemsJson = request()->items;
        $items = json_decode($itemsJson, true);
        return view('contact.checkOut', ['totalPrice' =>  $totalPrice, 'items' => $items]);
    }
    public function store()
    {
        $user = Auth::user();

        $itemsJson = request()->items;
        $items = json_decode($itemsJson, true);
        $item_id = request()->item_id;

        $item = Item::find($item_id);
        $order = Order::create([
            'user_id' => $user->id,
            'email' => request()->email,
            'phone_number' => request()->phone_number,
            'name' => request()->name,
            'address' => request()->address,
        ]);

        // Obtain the order_id
        $order_id = $order->id;
        // Create order items associated with the order
        foreach ($items as $item) {
            $product = Item::where('name', $item['item'])->first();
            // @dd($product);
            OrderItem::create([
                'order_id' => $order_id,
                'product_name' => $product->name,
                'price' => $item['price'] * $item['quantity'],
                'quantity' => $item['quantity'],
            ]);
        }
        CartItem::where('user_id', $user->id)->delete();

        return redirect()->route('Home');
    }
}
