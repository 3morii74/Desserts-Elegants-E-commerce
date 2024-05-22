<?php
namespace App\Http\Objects;
use Illuminate\Support\Facades\Storage;
use App\Models\OrderItem;
use App\Models\Item;
use App\Models\Order;
use Carbon\Carbon;
class OrderItemObject{
    private $id;
    private $order_id;
    private $product_name;
    private $price;
    private $quantity;
    private $created_at;
    private $updated_at;

    public function __construct($item)
    {
        $this->id = $item->id;
        $this->order_id = $item->order_id;
        $this->product_name = $item->product_name;
        $this->description = $item->description;
        $this->price = $item->price;
        $this->quantity = $item->quantity;
        $this->created_at = $item->created_at;
        $this->updated_at = $item->updated_at;
    }
    public function getOrderItem()
    {
        return [
            'id' => $this->id,
            'order_id' => $this->order_id,
            'product_name' => $this->product_name,
            'description' => $this->description,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
    public function getId()
    {
        return $this->id;
    }

}
