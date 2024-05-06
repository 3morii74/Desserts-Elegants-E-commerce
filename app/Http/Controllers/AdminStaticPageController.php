<?php

namespace App\Http\Controllers;
use App\Models\BestSellingItems;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\OrderStatistic;

class AdminStaticPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = BestSellingItems::all();
        $sortedItems = $items->sortByDesc('sales_volume');
        $topTwoItems = $sortedItems->take(2);
        $itemIds = $topTwoItems->pluck('item_id');
        $topTwoItemsFromTable = Item::whereIn('id', $itemIds)->get();
        $ordersStatistic  =OrderStatistic::all();
        $labels = [];
        $data = [];
        foreach ( $ordersStatistic as $orderStatistic)
        {
            $labels[] = $orderStatistic->month;
            // Add order count to data array
            $data[] = $orderStatistic->order_count;

        }

        return view('admin.statistics.index' , compact('topTwoItemsFromTable' , 'labels' ,'data'));
    }


}
