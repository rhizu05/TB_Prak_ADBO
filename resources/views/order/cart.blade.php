<x-customer-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center text-white">
            <h2 class="text-xl font-bold">Your Cart</h2>
            <a href="{{ url()->previous() }}" class="text-blue-200 hover:text-white text-sm flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Menu
            </a>
        </div>
    </x-slot>

    @if(session('error'))
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl shadow-sm relative z-10" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        @if(session('cart'))
            <ul class="divide-y divide-gray-100">
                @php $total = 0; @endphp
                @foreach(session('cart') as $id => $details)
                    @php $subtotal = $details['price'] * $details['quantity']; $total += $subtotal; @endphp
                    <li class="p-4 flex justify-between items-center">
                        <div class="flex items-center space-x-4">
                             @if($details['image'])
                                <img src="{{ asset('storage/' . $details['image']) }}" class="w-12 h-12 object-cover rounded-lg bg-gray-100">
                            @else
                                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center text-[10px] text-gray-500">No Img</div>
                            @endif
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">{{ $details['name'] }}</h4>
                                <p class="text-xs text-gray-500">{{ $details['quantity'] }} x Rp {{ number_format($details['price'], 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <span class="font-semibold text-gray-900 text-sm">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </li>
                @endforeach
            </ul>
            <div class="bg-gray-50 p-4 flex justify-between items-center border-t border-gray-100">
                <span class="font-bold text-gray-700">Total</span>
                <span class="font-bold text-xl text-blue-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
        @else
            <div class="p-8 text-center text-gray-500">
                <div class="mb-4 text-4xl">🛒</div>
                <p>Your cart is empty.</p>
                <a href="{{ url()->previous() }}" class="inline-block mt-4 text-blue-600 font-semibold hover:underline">Browse Menu</a>
            </div>
        @endif
    </div>

    @if(session('cart'))
        <form action="{{ route('checkout') }}" method="POST">
            @csrf
            <div class="mb-6">
                <label for="customer_name" class="block mb-2 text-sm font-medium text-gray-700">Your Name (Optional)</label>
                <input type="text" id="customer_name" name="customer_name" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 shadow-sm" placeholder="Guest">
            </div>
            
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg transition transform hover:scale-[1.02]">
                Place Order
            </button>
        </form>
    @endif
</x-customer-layout>
