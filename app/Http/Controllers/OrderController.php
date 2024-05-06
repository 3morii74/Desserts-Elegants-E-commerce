<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Item;
use App\Models\BestSellingItems;




use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Retrieve all orders
        $orderItems = collect();

        $orders = Order::all();

        foreach ($orders as $order)
        {
            $orderId = $order->id;
            // $ids = $order->pluck('id');

            $items = OrderItem::where('order_id', $orderId)->get();

            $orderItems = $orderItems->merge($items);
            // $orderItems += OrderItem::where('order_id' , $ids)->get();
        }


        // @dd($orderItems);
        return view('admin.orders.index', ['orders' => $orders , 'items' => $orderItems]);
    }
    public function done(Order $order)
    {
        $items = OrderItem::where('order_id' , $order->id)->delete();
        $order->delete();

        return to_route('admin.orders.index')->with('successful', 'order done successfully.');
    }
    public function indexClint()
    {
        $userId = auth()->id();
        // Retrieve all orders
        $orderItems = collect();

        $orders = Order::where('user_id', $userId)->get();

        //  @dd($orders);
        foreach ($orders as $order)
        {
            $orderId = $order->id;
            // $ids = $order->pluck('id');

            $items = OrderItem::where('order_id', $orderId)->get();

            $orderItems = $orderItems->merge($items);
            // $orderItems += OrderItem::where('order_id' , $ids)->get();
        }


        // @dd($orderItems);
        // return view('orders.index', ['orders' => $orders , 'items' => $orderItems]);
        return view('order.index',['orders' => $orders , 'items' => $orderItems]);

    }
    public function destoryClint($order)
    {
        //1- delete the post from database
            //select or find the post
            //delete the post from database
        // $order = ::find($postId);
        // @dd($order);
        $items = OrderItem::where('order_id' , $order)->delete();
        Order::where('id' , $order)->delete();
        //2- redirect to posts.index
        return to_route('order.indexClint');
    }
    public function create()
    {
        $items = Item::all();
        return view('admin.Orders.create' , ['items' => $items]);
    }

    public function store()
    {
        // $image = $request->file('image')->store('public/categories');
        $request = request()->item_id;
        $item_id = request()->item_id;

        $item = Item::find($item_id);

        // @dd($item);
        $order = Order::create([
            'user_id' => 1,
            'email' => request()->email,
            'phone_number' => request()->phone_number,
            'name' => request()->name,
            'address' => request()->address,
        ]);

        // Obtain the order_id
        $order_id = $order->id;
        // Create order items associated with the order
        OrderItem::create([
            'order_id' => $order_id,
            'product_name' => $item->name, // Assuming you have a product name in the request
            'price' => $item->price,
            'quantity' => request()->quantity,
        ]);
        $selling = BestSellingItems::where('item_id', $item_id)->first();
        $selling->sales_volume+= request()->quantity;
        $selling->save();

        return to_route('admin.orders.index')->with('success', 'Category created successfully.');
    }

    public function destroy(Order $order)
    {
        $items = OrderItem::where('order_id' , $order->id)->delete();
        $order->delete();

        return to_route('admin.orders.index')->with('danger', 'Category deleted successfully.');
    }
}
