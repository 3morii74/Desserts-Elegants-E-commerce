<?php
namespace App\Http\Objects;
use Illuminate\Support\Facades\Storage;
use App\Models\OrderItem;
use App\Models\Order;
use Carbon\Carbon;
use App\Mail\NewItemCreated;
use Illuminate\Support\Facades\Mail;
class UserObject{
    private $id;
    private $name;
    private $email;
    private $password;
    private $is_admin;
    private $remember_token;
    private $created_at;
    private $updated_at;

    public function __construct($user)
    {
        $this->id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->description = $user->description;
        $this->password = $user->password;
        $this->is_admin = $user->is_admin;
        $this->remember_token = $user->remember_token;
        $this->created_at = $user->created_at;
        $this->updated_at = $user->updated_at;
    }
    public function getUser()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'description' => $this->description,
            'password' => $this->password,
            'is_admin' => $this->is_admin,
            'remember_token' => $this->remember_token,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
    public function getId()
    {
        return $this->id;
    }
    public function SendEmail($item)
    {
        Mail::to($this->email)->send(new NewItemCreated($item->getId()));
    }
    public function IsAdmin()
    {
        return $this->is_admin;
    }
}
