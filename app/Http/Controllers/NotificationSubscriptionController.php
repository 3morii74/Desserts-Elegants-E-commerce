<?php

namespace App\Http\Controllers;
use App\Models\NotificationSubscription;
use App\Models\Item;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;


use App\Models\User;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\NewItemCreated;

class NotificationSubscriptionController extends Controller
{
    public function subscribe()
    {
        $user = auth()->user();
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
        $ItemController = new ItemController;
        $item = $ItemController->getItem($item);
        $userController = new UserController;
        $users = $userController->getAllUserNotificationSubscription();
        foreach ($users as $id) {
            $user = $userController->getUser($id->user_id);
            $user->SendEmail($item);
        }
        return to_route('admin.items.index')->with('success', 'Item created successfully.');
    }
}
