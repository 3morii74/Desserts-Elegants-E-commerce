<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\NotificationSubscription;

class WelcomeController extends Controller
{
    public function index()
    {
        $specials = Category::all();
        $user = auth()->user();
        $isSubscipe=0;
        if($user)
        {
            $isSubscipe = NotificationSubscription::where('user_id', $user->id)->first()  == Null? 0 : 1 ;


        }

        return view('welcome', compact('specials' , 'isSubscipe'));
        // @dd($isSubscipe);
    }
    public function thankyou()
    {
        return view('thankyou');
    }
}
