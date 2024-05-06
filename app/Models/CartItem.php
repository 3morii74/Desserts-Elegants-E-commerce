<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'category_id', 'quantity', 'price','item'];

    // Define relationship with Menu model
    // public function category()
    // {
    //     return $this->belongsTo(Category::class);
    // }

    // // Define relationship with User model
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    // // Calculate subtotal for the cart item
    // public function subtotal()
    // {
    //     return $this->quantity * $this->price;
    // }

    // // Override create method to automatically set user_id
    // public static function create(array $attributes = [])
    // {
    //     // Retrieve the authenticated user
    //     $user = Auth::user();

    //     // Assign the user_id from the authenticated user
    //     $attributes['user_id'] = $user->id;

    //     // Call the parent create method
    //     return parent::create($attributes);
    // }
}
