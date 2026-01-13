<x-app-layout>
    <x-slot name="header">
        Cashier Dashboard
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 border-l-4 border-l-orange-500">
            <h3 class="font-bold text-gray-500 text-sm">Pending Payment</h3>
            <p class="text-3xl font-bold text-orange-500 mt-2">{{ $pendingCount }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 border-l-4 border-l-green-500">
            <h3 class="font-bold text-gray-500 text-sm">Paid Orders (All Time)</h3>
            <p class="text-3xl font-bold text-green-500 mt-2">{{ $paidCount }}</p>
        </div>
        <!-- Today's Sales -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 border-l-4 border-l-blue-500">
            <h3 class="font-bold text-gray-500 text-sm">Penjualan Hari Ini</h3>
            <p class="text-3xl font-bold text-blue-600 mt-2">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-400 mt-1">{{ now()->format('d M Y') }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 border-l-4 border-l-purple-500">
            <h3 class="font-bold text-gray-500 text-sm">Pesanan Hari Ini</h3>
            <p class="text-3xl font-bold text-purple-600 mt-2">{{ $todayPaidOrders }}</p>
            <p class="text-xs text-gray-400 mt-1">Terbayar</p>
        </div>
    </div>

    <div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h3 class="font-bold text-lg">Recent Orders</h3>
        </div>
        <table class="w-full text-left">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3">Order ID</th>
                    <th class="px-6 py-3">Table</th>
                    <th class="px-6 py-3">Amount</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($pendingPayments as $order)
                    <tr>
                        <td class="px-6 py-4 font-medium">#{{ $order->id }}</td>
                        <td class="px-6 py-4">Table {{ $order->table->number }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">
                                {{ ucfirst($order->payment?->payment_method ?? 'Unknown') }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <form action="{{ route('kasir.payment.confirm', $order->id) }}" method="POST" onsubmit="return confirm('Confirm payment received?');">
                                @csrf
                                <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white text-xs font-bold py-1.5 px-3 rounded shadow">
                                    Confirm Paid
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No pending payments.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
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
