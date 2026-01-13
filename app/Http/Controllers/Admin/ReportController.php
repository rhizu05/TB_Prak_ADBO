<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Get filter parameters
        $startDate = $request->input('start_date', Carbon::today()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::today()->format('Y-m-d'));
        $period = $request->input('period', '30days');

        // Apply preset periods
        if ($period === 'today') {
            $startDate = Carbon::today()->format('Y-m-d');
            $endDate = Carbon::today()->format('Y-m-d');
        } elseif ($period === '7days') {
            $startDate = Carbon::today()->subDays(6)->format('Y-m-d');
            $endDate = Carbon::today()->format('Y-m-d');
        } elseif ($period === '30days') {
            $startDate = Carbon::today()->subDays(29)->format('Y-m-d');
            $endDate = Carbon::today()->format('Y-m-d');
        }

        $startDateTime = Carbon::parse($startDate)->startOfDay();
        $endDateTime = Carbon::parse($endDate)->endOfDay();

        // Revenue in period (paid orders only)
        $periodRevenue = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDateTime, $endDateTime])
            ->sum('total_amount');

        // Orders in period
        $periodOrders = Order::whereBetween('created_at', [$startDateTime, $endDateTime])->count();

        // Paid orders in period
        $paidOrders = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDateTime, $endDateTime])
            ->count();

        // Average order value
        $avgOrderValue = $paidOrders > 0 ? $periodRevenue / $paidOrders : 0;

        // Transactions table
        $orders = Order::with('table')
            ->whereBetween('created_at', [$startDateTime, $endDateTime])
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->appends($request->query());

        // Chart data - Daily revenue for the period
        $chartData = $this->getChartDataForPeriod($startDateTime, $endDateTime);

        return view('admin.reports.index', compact(
            'periodRevenue',
            'periodOrders',
            'paidOrders',
            'avgOrderValue',
            'orders',
            'chartData',
            'startDate',
            'endDate',
            'period'
        ));
    }

    protected function getChartDataForPeriod($startDate, $endDate)
    {
        $labels = [];
        $revenues = [];
        $orderCounts = [];

        $current = $startDate->copy();
        while ($current <= $endDate) {
            $dayStart = $current->copy()->startOfDay();
            $dayEnd = $current->copy()->endOfDay();

            $labels[] = $current->format('d M');
            
            $dayRevenue = Order::where('payment_status', 'paid')
                ->whereBetween('created_at', [$dayStart, $dayEnd])
                ->sum('total_amount');
            $revenues[] = (float) $dayRevenue;

            $dayOrders = Order::whereBetween('created_at', [$dayStart, $dayEnd])->count();
            $orderCounts[] = $dayOrders;

            $current->addDay();
        }

        return [
            'labels' => $labels,
            'revenues' => $revenues,
            'orders' => $orderCounts,
        ];
    }

    public function export(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::today()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::today()->format('Y-m-d'));

        $startDateTime = Carbon::parse($startDate)->startOfDay();
        $endDateTime = Carbon::parse($endDate)->endOfDay();

        $orders = Order::with('table')
            ->whereBetween('created_at', [$startDateTime, $endDateTime])
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = 'laporan_' . $startDate . '_to_' . $endDate . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($orders) {
            $file = fopen('php://output', 'w');
            
            // BOM for Excel UTF-8
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            
            // Header row
            fputcsv($file, ['Order ID', 'Tanggal', 'Meja', 'Pelanggan', 'Total', 'Status Bayar', 'Status Pesanan']);

            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->id,
                    $order->created_at->format('Y-m-d H:i:s'),
                    $order->table?->number ?? '-',
                    $order->customer_name ?? '-',
                    $order->total_amount,
                    $order->payment_status,
                    $order->order_status,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
