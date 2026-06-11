<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class QueryController extends Controller
{
    private function buildQuery()
    {
        return DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->selectRaw('
                users.name as customer,
                COUNT(DISTINCT orders.id) as total_orders,
                SUM(order_items.quantity) as total_items,
                ROUND(SUM(orders.total_amount), 2) as total_spent,
                ROUND(AVG(orders.total_amount), 2) as avg_ticket,
                MAX(orders.total_amount) as max_order,
                MIN(orders.total_amount) as min_order
            ')
            ->groupBy('users.name')
            ->orderByDesc('total_spent');
    }

    public function fast(): View
    {
        $start = microtime(true);

        $orders = Cache::remember('orders_report_v4', 600, function () {
            return $this->buildQuery()->get()->map(fn($row) => (array) $row)->toArray();
        });

        $time = microtime(true) - $start;

        return view('fast-query', [
            'orders' => $orders,
            'time'   => $time,
        ]);
    }

    public function slow(): View
    {
        set_time_limit(120);
        $start = microtime(true);

        $orders = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->selectRaw('
            users.name as customer,
            COUNT(DISTINCT orders.id) as total_orders,
            SUM(order_items.quantity) as total_items,
            ROUND(SUM(orders.total_amount), 2) as total_spent,
            ROUND(AVG(orders.total_amount), 2) as avg_ticket,
            MAX(orders.total_amount) as max_order,
            MIN(orders.total_amount) as min_order
        ')
            ->groupBy('users.name')
            ->orderByDesc('total_spent')
            ->get();

        $time = microtime(true) - $start;

        return view('slow-query', compact('orders', 'time'));
    }

    public function benchmark(): View
    {
        $runs = 10;

        $slowTimes = [];
        for ($i = 0; $i < $runs; $i++) {
            $start = microtime(true);
            DB::table('orders')
                ->join('users', 'orders.user_id', '=', 'users.id')
                ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->selectRaw('
                users.name as customer,
                COUNT(DISTINCT orders.id) as total_orders,
                SUM(order_items.quantity) as total_items,
                ROUND(SUM(orders.total_amount), 2) as total_spent,
                ROUND(AVG(orders.total_amount), 2) as avg_ticket
            ')
                ->groupBy('users.name')
                ->orderByDesc('total_spent')
                ->get();
            $slowTimes[] = microtime(true) - $start;
        }

        Cache::forget('orders_report_v4');
        Cache::remember('orders_report_v4', 600, fn() =>
        $this->buildQuery()->get()->map(fn($r) => (array) $r)->toArray()
        );

        $fastTimes = [];
        for ($i = 0; $i < $runs; $i++) {
            $start = microtime(true);
            Cache::get('orders_report_v4');
            $fastTimes[] = microtime(true) - $start;
        }

        return view('benchmark', [
            'slowAvg'  => array_sum($slowTimes) / $runs,
            'fastAvg'  => array_sum($fastTimes) / $runs,
            'slowTimes' => $slowTimes,
            'fastTimes' => $fastTimes,
            'speedup'  => (array_sum($slowTimes) / $runs) / (array_sum($fastTimes) / $runs),
        ]);
    }
}
