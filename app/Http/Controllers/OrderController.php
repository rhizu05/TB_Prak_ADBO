<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function show($tableNumber)
    {
        $table = \App\Models\Table::where('number', $tableNumber)->where('is_active', true)->firstOrFail();

        // Store table info in session
        session(['table_number' => $tableNumber]);
        session(['table_id' => $table->id]);

        $categories = \App\Models\Category::with(['products' => function ($query) {
            $query->where('is_available', true);
        }])->get();

        return view('order.menu', compact('table', 'categories'));
    }

    public function addToCart(Request $request)
    {
        // Simple session cart implementation
        // cart = [ product_id => [quantity, name, price, image, note] ]
        $cart = session()->get('cart', []);
        
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);
        $note = $request->input('note', '');

        $product = \App\Models\Product::findOrFail($productId);

        if(isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
            $cart[$productId]['note'] = $note; // Update note
        } else {
            $cart[$productId] = [
                "name" => $product->name,
                "quantity" => $quantity,
                "price" => $product->price,
                "image" => $product->image,
                "note" => $note
            ];
        }

        session()->put('cart', $cart);
        
        return redirect()->back()->with('success', 'Item added to cart');
    }

    public function cart()
    {
        if(!session()->has('table_number')) {
            return redirect('/'); // Redirect if session expired
        }
        return view('order.cart');
    }

    public function checkout(Request $request) 
    {
         if(!session()->has('table_id')) {
             return redirect('/');
         }

        $cart = session()->get('cart');

        if(!$cart) {
            return redirect()->back()->with('error', 'Cart is empty');
        }

        // Create Order
        $order = \App\Models\Order::create([
            'table_id' => session('table_id'),
            'customer_name' => $request->input('customer_name', 'Guest'),
            'total_amount' => 0, // Will calculate below
            'order_status' => 'pending',
            'payment_status' => 'pending',
        ]);

        $total = 0;
        foreach($cart as $id => $details) {
            $subtotal = $details['price'] * $details['quantity'];
            $total += $subtotal;
            
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'quantity' => $details['quantity'],
                'price' => $details['price'],
                'note' => $details['note'] ?? null,
            ]);
        }
        
        $order->update(['total_amount' => $total]);
        
        // Clear cart
        session()->forget('cart');

        return redirect()->route('payment.show', $order->id);
    }

    public function status(\App\Models\Order $order)
    {
        return view('order.status', compact('order'));
    }

    public function markReady(\App\Models\Order $order)
    {
        // This should normally be protected by Koki middleware
        $order->update(['order_status' => 'siap']); // Mark as ready
        
        return redirect()->back()->with('success', 'Order marked as Ready!');
    }
}
