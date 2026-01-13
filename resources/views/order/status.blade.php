<x-customer-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center text-white">
            <h2 class="text-xl font-bold">Order Tracking</h2>
            <span class="text-sm bg-white/20 px-3 py-1 rounded-full">#{{ $order->id }}</span>
        </div>
    </x-slot>

    <div class="text-center py-6">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-green-100 shadow-lg mb-4 text-green-500">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        
        <h2 class="text-2xl font-bold text-gray-800 mb-1">Order Placed!</h2>
        <p class="text-gray-500 mb-8 text-sm">Table #{{ session('table_number') }}</p>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden text-left mb-6">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-gray-500 text-sm">Status</span>
                    <span class="px-3 py-1 rounded-full text-sm font-semibold 
                        {{ $order->order_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                           ($order->order_status === 'proses' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                        {{ ucfirst($order->order_status) }}
                    </span>
                </div>
                
                 <div class="flex justify-between items-center mb-4">
                    <span class="text-gray-500 text-sm">Total Amount</span>
                    <span class="text-xl font-bold text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>

                <div class="border-t border-gray-100 pt-6 mt-4 text-center">
                    @if($order->payment_status === 'pending')
                         <p class="text-sm text-gray-600 mb-4">Please select a payment method.</p>
                         <a href="{{ route('payment.show', $order->id) }}" class="inline-block w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg transition transform hover:scale-[1.02]">
                            Proceed to Payment
                        </a>
                    @else
                        <div class="flex flex-col items-center">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="text-green-600 font-bold mb-1">Payment Completed</p>
                            <p class="text-xs text-gray-500">Thank you for your order!</p>
                        </div>
                    @endif
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4">
                <h4 class="font-semibold text-gray-700 text-sm mb-3">Order Summary</h4>
                <ul class="space-y-3">
                    @foreach($order->items as $item)
                        <li class="flex justify-between text-sm">
                            <span class="text-gray-600 font-medium">{{ $item->quantity }}x {{ $item->product->name }}</span>
                            <span class="font-semibold text-gray-900">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        
        <a href="{{ route('order.menu', session('table_number')) }}" class="inline-flex items-center text-blue-600 font-semibold hover:text-blue-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Order More Items
        </a>
    </div>
</x-customer-layout>
