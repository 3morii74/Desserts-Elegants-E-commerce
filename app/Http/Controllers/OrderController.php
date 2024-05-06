<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Item;
use App\Models\BestSellingItems;
use App\Models\OrderStatistic;

use Carbon\Carbon;




use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function indexAdmin()
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
    public function done()
    {
        $orderId = request()->id;
        $order = Order::findOrFail($orderId);
        $orderDate = Carbon::parse($order->created_at);

        OrderStatistic::updateOrCreate(
            ['year' =>$orderDate->year, 'month' => $orderDate->format('F')], // Search criteria
            ['order_count' => OrderStatistic::raw('order_count + 1')] // Update or create data
        );

        $items = OrderItem::where('order_id' , $order->id)->delete();
        $order->delete();

        return to_route('admin.orders.index')->with('successful', 'order done successfully.');
    }
    public function index()
    {
        $userId = auth()->id();
        $orderItems = collect();

        $orders = Order::where('user_id', $userId)->get();

        foreach ($orders as $order)
        {
            $orderId = $order->id;

            $items = OrderItem::where('order_id', $orderId)->get();

            $orderItems = $orderItems->merge($items);
        }
        return view('order.index',['orders' => $orders , 'items' => $orderItems]);

    }
    public function destory($order)
    {
        $items = OrderItem::where('order_id' , $order)->delete();
        Order::where('id' , $order)->delete();
        return to_route('order.indexClint');
    }
    public function createAdmin()
    {
        $items = Item::all();
        return view('admin.Orders.create' , ['items' => $items]);
    }

    public function storeAdmin()
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

    public function destroyAdmin(Order $order)
    {
        $items = OrderItem::where('order_id' , $order->id)->delete();
        $order->delete();

        return to_route('admin.orders.index')->with('danger', 'Category deleted successfully.');
    }
}
