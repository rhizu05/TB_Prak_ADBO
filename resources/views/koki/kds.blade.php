<x-app-layout>
    <x-slot name="header">
        Kitchen Display System
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($orders as $order)
            <div class="bg-white rounded-xl shadow border-l-4 border-l-blue-500 overflow-hidden">
                <div class="p-4 border-b border-gray-100 flex justify-between items-center bg-blue-50">
                    <div>
                         <span class="font-bold text-lg block">Table {{ $order->table->number }}</span>
                         <span class="text-xs text-gray-500">{{ $order->created_at->format('H:i') }}</span>
                    </div>
                    <span class="text-sm text-gray-500">#{{ $order->id }}</span>
                </div>
                <div class="p-4">
                    <p class="text-xs text-gray-500 mb-2">
                        Wait Time: 
                        <span class="font-bold {{ $order->created_at->diffInMinutes(now()) > 15 ? 'text-red-500' : 'text-green-500' }}">
                            {{ $order->created_at->diffInMinutes(now()) }} mins
                        </span>
                    </p>
                    <ul class="space-y-3">
                        @foreach($order->items as $item)
                        <li class="flex justify-between border-b border-gray-50 pb-2 last:border-0">
                            <div>
                                <span class="font-bold text-gray-800">{{ $item->quantity }}x</span>
                                <span class="font-medium text-gray-700">{{ $item->product->name }}</span>
                                @if($item->note)
                                    <p class="text-xs text-red-500 italic mt-0.5">Note: {{ $item->note }}</p>
                                @endif
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="p-4 bg-gray-50 border-t border-gray-100">
                    <form action="{{ route('koki.order.ready', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                            Mark as Ready
                        </button>
                    </form>
                </div>
            </div>
        @empty
             <div class="col-span-full text-center py-10 text-gray-500">
                <p>No active orders to cook.</p>
            </div>
        @endforelse
    </div>

    <!-- Auto-refresh indicator -->
    <div class="fixed bottom-4 right-4 bg-gray-800 text-white text-xs px-3 py-2 rounded-full shadow-lg flex items-center gap-2">
        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
        <span>Auto-refresh: <span id="countdown">15</span>s</span>
    </div>

    <script>
        // Auto-refresh every 15 seconds with countdown
        let seconds = 15;
        const countdownEl = document.getElementById('countdown');
        
        setInterval(() => {
            seconds--;
            countdownEl.textContent = seconds;
            if (seconds <= 0) {
                window.location.reload();
            }
        }, 1000);
    </script>
</x-app-layout>
