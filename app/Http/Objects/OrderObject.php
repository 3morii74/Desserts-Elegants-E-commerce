<?php
namespace App\Http\Objects;
use Illuminate\Support\Facades\Storage;
use App\Models\OrderItem;
use App\Models\Order;
use Carbon\Carbon;
use App\Mail\OrderDone;
use Illuminate\Support\Facades\Mail;
class OrderObject{
    private $id;
    private $user_id;
    private $email;
    private $phone_number;
    private $address;
    private $name;
    private $created_at;
    private $updated_at;

    public function __construct($order)
    {
        $this->id = $order->id;
        $this->user_id = $order->user_id;
        $this->email = $order->email;
        $this->description = $order->description;
        $this->phone_number = $order->phone_number;
        $this->address = $order->address;
        $this->name = $order->name;
        $this->created_at = $order->created_at;
        $this->updated_at = $order->updated_at;
    }
    public function getOrder()
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'email' => $this->email,
            'description' => $this->description,
            'phone_number' => $this->phone_number,
            'address' => $this->address,
            'name' => $this->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
    public function getId()
    {
        return $this->id;
    }
    public function DoneOrder()
    {
        Mail::to($this->email)->send(new OrderDone($this));
    }

}
