<?php

namespace App\Http\Controllers;
use App\Models\NotificationSubscription;
use App\Models\Item;

use App\Models\User;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\NewItemCreated;

class NotificationSubscriptionController extends Controller
{
    public function subscribe()
    {
        $user = auth()->user();
        // @dd($user);
        NotificationSubscription::create([
            'user_id' => $user->id
        ]);

        return redirect()->back()->with('success', 'Subscribed successfully');
    }

    public function unsubscribe()
    {
        $user = auth()->user();
        NotificationSubscription::where('user_id', $user->id)->delete();

        return redirect()->back()->with('success', 'Unsubscribed successfully');
    }

    public function notify($item)
    {
        $item = Item::findOrFail($item);
        $users = NotificationSubscription::all();

        foreach ($users as $user) {
            $email =User::where('id',$user->user_id)->first();
            $email = $email->email;
            // @dd($email);
            Mail::to($email)->send(new NewItemCreated($item));
        }
        return to_route('admin.items.index')->with('success', 'Item created successfully.');
    }
}
