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
    public function store(Request $request)
    {
        $input = request()->all();
        // @dd($request);
        $validatedData = $request->validate([
            'name' => 'required|string|min:3|regex:/^[a-zA-Z\s]+$/u|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:6|max:255',
        ]);
        // Generate a random ID
        $randomId = Str::uuid();

        // Generate a token
        $token = Str::random(15);

        // Create the user
        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            // assuming your User model has a column 'random_id'
            'remember_token' => $token // assuming your User model has a column 'token'
        ]);
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            return redirect()->route('Home');
        }

        // You can do further operations like sending emails, logging in the user, etc.

        return redirect()->route('contact.login');
    }
}
