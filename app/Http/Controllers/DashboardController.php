<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin()
    {
        $totalUsers = \App\Models\User::count();
        $todayRevenue = \App\Models\Order::where('payment_status', 'paid')
                            ->whereDate('created_at', now()->today())
                            ->sum('total_amount');
        $totalOrders = \App\Models\Order::count();

        return view('admin.dashboard', compact('totalUsers', 'todayRevenue', 'totalOrders'));
    }

    public function kasir()
    {
        $pendingPayments = \App\Models\Order::where('payment_status', 'pending')
                            ->with('table', 'payment')
                            ->whereHas('payment')
                            ->get();
        
        $pendingCount = \App\Models\Order::where('payment_status', 'pending')->count();
        $paidCount = \App\Models\Order::where('payment_status', 'paid')->count();

        // Today's sales data
        $todayRevenue = \App\Models\Order::where('payment_status', 'paid')
                            ->whereDate('created_at', now()->today())
                            ->sum('total_amount');
        $todayPaidOrders = \App\Models\Order::where('payment_status', 'paid')
                            ->whereDate('created_at', now()->today())
                            ->count();

        return view('kasir.dashboard', compact('pendingPayments', 'pendingCount', 'paidCount', 'todayRevenue', 'todayPaidOrders'));
    }

    public function koki()
    {
        $queueCount = \App\Models\Order::where('order_status', 'proses')->count();
        $completedToday = \App\Models\Order::where('order_status', 'siap')
                            ->whereDate('updated_at', now()->today())
                            ->count();
        
        return view('koki.dashboard', compact('queueCount', 'completedToday'));
    }
}
