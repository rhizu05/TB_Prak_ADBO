<x-customer-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center text-white">
            <h2 class="text-xl font-bold">Checkout & Pay</h2>
            <a href="{{ route('order.status', $order->id) }}" class="text-blue-200 hover:text-white text-sm bg-white/10 px-3 py-1 rounded-lg">
                Cancel
            </a>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6 relative z-10">
        <div class="p-6 border-b border-gray-100/50 bg-gray-50/50">
             <div class="flex justify-between items-end">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Total to Pay</p>
                    <h3 class="text-3xl font-bold text-gray-900 tracking-tight">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</h3>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-400">Order #{{ $order->id }}</p>
                </div>
            </div>
        </div>
        
        <form action="{{ route('payment.pay', $order->id) }}" method="POST">
            @csrf
            
            <div class="p-4 space-y-3">
                <p class="px-2 text-xs font-bold text-gray-400 uppercase tracking-widest">Select Method</p>
                
                <label class="relative flex items-center p-4 rounded-xl border border-gray-200 cursor-pointer hover:bg-blue-50 hover:border-blue-200 transition bg-white shadow-sm">
                    <input type="radio" name="payment_method" value="cash" class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300" required>
                    <div class="ml-4 flex-1">
                        <span class="block text-base font-bold text-gray-900">Bayar di Kasir (Cash)</span>
                        <span class="block text-xs text-gray-500">Bayar tunai langsung di kasir</span>
                    </div>
                     <div class="text-3xl p-2 bg-green-100 rounded-lg">💵</div>
                </label>

                <label class="relative flex items-center p-4 rounded-xl border border-gray-200 cursor-pointer hover:bg-blue-50 hover:border-blue-200 transition bg-white shadow-sm">
                    <input type="radio" name="payment_method" value="qris" class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                    <div class="ml-4 flex-1">
                        <span class="block text-base font-bold text-gray-900">QRIS / E-Wallet</span>
                        <span class="block text-xs text-gray-500">Scan QR Code (GoPay, OVO, Dana)</span>
                    </div>
                    <div class="text-3xl p-2 bg-blue-100 rounded-lg">📱</div>
                </label>
            </div>

            <div class="p-6 bg-gray-50 border-t border-gray-100 mt-2">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-xl shadow-lg transition transform hover:scale-[1.01] flex justify-center items-center gap-2 text-lg">
                    <span>Pay Now</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </form>
    </div>
</x-customer-layout>
