<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('order.table')
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);
                            
        return view('kasir.payments.index', compact('payments'));
    }
}
