<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('table')
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);
                        
        return view('kasir.orders.index', compact('orders'));
    }
}
