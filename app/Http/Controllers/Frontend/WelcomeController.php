<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $specials = Category::all();
        // @dd($specials);
        return view('welcome', compact('specials'));
    }
    public function thankyou()
    {
        return view('thankyou');
    }
}
