<?php

namespace App\Http\Controllers\Koki;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class KitchenController extends Controller
{
    public function index()
    {
        $orders = Order::where('order_status', 'proses')
            ->with(['items.product', 'table'])
            ->orderBy('updated_at', 'asc')
            ->get();

        return view('koki.kds', compact('orders'));
    }
}
