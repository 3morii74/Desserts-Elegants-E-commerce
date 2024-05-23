<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\NotificationSubscription;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AdminStaticPageController;
class WelcomeController extends Controller
{
    public function index()
    {
        $itemController = new ItemController;
        $itemObjects[] = $itemController->getAllItems();
        $specials = Category::all();
        $user = auth()->user();
        $isSubscipe=0;
        if($user)
        {
            $isSubscipe = NotificationSubscription::where('user_id', $user->id)->first()  == Null? 0 : 1 ;
        }
        $staticPage = new AdminStaticPageController;
        $topTwoItemsFromTable = $staticPage->BestSelling();
        return view('welcome', compact('specials' , 'isSubscipe' , 'topTwoItemsFromTable'));

    }
    public function thankyou()
    {
        return view('thankyou');
    }
}
