<?php
// app/Services/IncrementCartItemDecorator.php
namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;
use App\Models\Item;

class IncrementCartItemDecorator extends CartItemOperationDecorator
{
    public function updateItem($item)
    {
        $user = Auth::user();
        $cartItem = CartItem::where('user_id', $user->id)
            ->where('item', $item)
            ->first();

        $itemObject = Item::where('name', $item)->first();

        $cartItem->update([
            'quantity' => $cartItem->quantity + 1,
            'price' => $cartItem->price + $itemObject->price,
        ]);

        // Call the next decorator or base operation
        $this->cartItemOperation->updateItem($item);
    }
}


