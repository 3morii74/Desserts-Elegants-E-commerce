<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Objects\UserObject;
use App\Models\NotificationSubscription;

class UserController extends Controller
{
    private $usersObjects = [];


    public function getAllUsers()
    {

        $Users = User::all();
        foreach ($Users as $user) {
         $this->usersObjects[] = new UserObject($user);
        }
        return $this->usersObjects;
    }
    public function getUser($id)
    {
        $Users= $this->getAllUsers();
        foreach ($Users as $user) {
            if ($user->getId() == $id)
            {
                return $user;
            }
           }
           return false;
    }
    public function getAllUserNotificationSubscription()
    {

        $users = NotificationSubscription::all();
        return $users;
    }

}
