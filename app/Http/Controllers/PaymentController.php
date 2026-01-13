<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use Midtrans\Config;
use Midtrans\CoreApi;
use Midtrans\Transaction;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Configure Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function show(Order $order)
    {
        if ($order->payment_status !== 'pending') {
            return redirect()->route('order.status', $order->id);
        }

        return view('order.payment', compact('order'));
    }

    public function pay(Request $request, Order $order)
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:cash,qris',
        ]);

        if ($order->payment_status !== 'pending') {
            return redirect()->route('order.status', $order->id);
        }

        // Create Payment Record
        $payment = Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'amount' => $order->total_amount,
                'payment_method' => $validated['payment_method'],
                'status' => 'pending',
            ]
        );

        if ($validated['payment_method'] === 'cash') {
            return redirect()->route('payment.cash', $order->id);
        }

        if ($validated['payment_method'] === 'qris') {
            return $this->createQrisPayment($order, $payment);
        }
    }

    protected function createQrisPayment(Order $order, Payment $payment)
    {
        $orderId = 'ORDER-' . $order->id . '-' . time();

        $params = [
            'payment_type' => 'qris',
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $order->total_amount,
            ],
            'qris' => [
                'acquirer' => 'gopay', // gopay qris
            ],
            'customer_details' => [
                'first_name' => $order->customer_name ?? 'Guest',
            ],
        ];

        try {
            $response = CoreApi::charge($params);

            // Update payment with transaction details
            $payment->update([
                'transaction_id' => $orderId,
            ]);

            // Store QRIS data in session for display
            session([
                'qris_data' => [
                    'order_id' => $orderId,
                    'qr_string' => $response->actions[0]->url ?? null,
                    'expire_time' => $response->expiry_time ?? null,
                ]
            ]);

            return redirect()->route('payment.qris', $order->id);

        } catch (\Exception $e) {
            return redirect()->route('order.status', $order->id)
                ->with('error', 'Gagal membuat pembayaran QRIS: ' . $e->getMessage());
        }
    }

    public function showQris(Order $order)
    {
        $qrisData = session('qris_data');
        
        if (!$qrisData) {
            return redirect()->route('payment.show', $order->id)
                ->with('error', 'Sesi QRIS expired. Silakan coba lagi.');
        }

        return view('order.qris', [
            'order' => $order,
            'qrisData' => $qrisData,
        ]);
    }

    public function showCash(Order $order)
    {
        return view('order.cash', compact('order'));
    }

    public function checkStatus(Order $order)
    {
        $payment = $order->payment;
        
        if (!$payment || !$payment->transaction_id) {
            return response()->json(['status' => 'pending']);
        }

        try {
            $status = Transaction::status($payment->transaction_id);
            
            if (in_array($status->transaction_status, ['capture', 'settlement'])) {
                // Payment successful
                $order->update([
                    'payment_status' => 'paid',
                    'order_status' => 'proses',
                ]);
                
                $payment->update([
                    'status' => 'success',
                    'paid_at' => now(),
                ]);

                return response()->json(['status' => 'success']);
            }

            if (in_array($status->transaction_status, ['deny', 'cancel', 'expire'])) {
                $payment->update(['status' => 'failed']);
                return response()->json(['status' => 'failed']);
            }

            return response()->json(['status' => 'pending']);

        } catch (\Exception $e) {
            return response()->json(['status' => 'pending', 'error' => $e->getMessage()]);
        }
    }

    public function notification(Request $request)
    {
        $notif = new \Midtrans\Notification();

        $transactionStatus = $notif->transaction_status;
        $orderId = $notif->order_id;

        // Extract order ID from format ORDER-{id}-{timestamp}
        preg_match('/ORDER-(\d+)-/', $orderId, $matches);
        $orderIdNum = $matches[1] ?? null;

        if (!$orderIdNum) {
            return response()->json(['message' => 'Invalid order ID']);
        }

        $order = Order::find($orderIdNum);
        if (!$order) {
            return response()->json(['message' => 'Order not found']);
        }

        $payment = $order->payment;

        if (in_array($transactionStatus, ['capture', 'settlement'])) {
            $order->update([
                'payment_status' => 'paid',
                'order_status' => 'proses',
            ]);
            
            if ($payment) {
                $payment->update([
                    'status' => 'success',
                    'paid_at' => now(),
                ]);
            }
        } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
            if ($payment) {
                $payment->update(['status' => 'failed']);
            }
        }

        return response()->json(['message' => 'OK']);
    }

    public function confirm(Order $order)
    {
        $order->update([
            'payment_status' => 'paid',
            'order_status' => 'proses',
        ]);

        if ($order->payment) {
            $order->payment->update([
                'status' => 'success',
                'paid_at' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Pembayaran dikonfirmasi! Pesanan dikirim ke dapur.');
    }
}
