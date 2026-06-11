<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class QueryController extends Controller
{
    public function fast(): View
    {
        $start = microtime(true);

        $orders = Cache::remember('orders_report', 600, function () {
            return DB::table('orders')
                ->join('users', 'orders.user_id', '=', 'users.id')
                ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->select(
                    'orders.id',
                    'users.name',
                    'products.name as product_name',
                    'order_items.quantity',
                    'orders.total_amount'
                )
                ->limit(5000)
                ->get();
        });

        $time = microtime(true) - $start;

        return view('fast-query', compact('orders', 'time'));
    }

    public function slow(): View
    {
        $start = microtime(true);

        $orders = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select(
                'orders.id',
                'users.name',
                'products.name as product_name',
                'order_items.quantity',
                'orders.total_amount'
            )
            ->limit(5000)
            ->get();

        $time = microtime(true) - $start;

        return view('slow-query', compact('orders', 'time'));
    }
}
