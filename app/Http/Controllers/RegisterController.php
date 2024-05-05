<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function create()
    {
        return view('contact.create');
    }
    public function store()
    {
        $input = request()->all();

        // Generate a random ID
        $randomId = Str::uuid();

        // Generate a token
        $token = Str::random(15);

        // Create the user
        User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            // assuming your User model has a column 'random_id'
            'remember_token' => $token // assuming your User model has a column 'token'
        ]);

        // You can do further operations like sending emails, logging in the user, etc. 

        return redirect()->route('contact.login');
    }
}
