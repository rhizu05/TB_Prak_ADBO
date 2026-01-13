<x-customer-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center text-white">
            <h2 class="text-xl font-bold">Pembayaran QRIS</h2>
            <span class="text-sm bg-white/20 px-3 py-1 rounded-full">#{{ $order->id }}</span>
        </div>
    </x-slot>

    <div class="text-center py-6">
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <h3 class="text-lg font-bold text-gray-800 mb-2">Scan QR Code</h3>
            <p class="text-sm text-gray-500 mb-4">Gunakan aplikasi e-wallet (GoPay, OVO, DANA, dll)</p>
            
            <!-- QR Code Display -->
            <div class="flex justify-center mb-4">
                @if(isset($qrisData['qr_string']))
                    <img src="{{ $qrisData['qr_string'] }}" alt="QRIS Code" class="w-64 h-64 border-4 border-blue-100 rounded-xl">
                @else
                    <div class="w-64 h-64 bg-gray-100 rounded-xl flex items-center justify-center">
                        <p class="text-gray-400 text-sm">QR Code tidak tersedia</p>
                    </div>
                @endif
            </div>

            <div class="bg-blue-50 rounded-lg p-4 mb-4">
                <p class="text-sm text-gray-600">Total Pembayaran</p>
                <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
            </div>

            <!-- Status Indicator -->
            <div id="statusIndicator" class="flex items-center justify-center gap-2 text-gray-500">
                <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span id="statusText">Menunggu pembayaran...</span>
            </div>
        </div>

        <p class="text-sm text-gray-500 mb-4">
            Halaman ini akan otomatis terupdate setelah pembayaran berhasil
        </p>

        <a href="{{ route('payment.show', $order->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
            ← Pilih metode lain
        </a>
    </div>

    <script>
        // Poll payment status every 3 seconds
        function checkPaymentStatus() {
            fetch('{{ route("payment.check", $order->id) }}')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        document.getElementById('statusText').textContent = 'Pembayaran berhasil! Mengalihkan...';
                        document.getElementById('statusIndicator').classList.remove('text-gray-500');
                        document.getElementById('statusIndicator').classList.add('text-green-600');
                        setTimeout(() => {
                            window.location.href = '{{ route("order.status", $order->id) }}';
                        }, 1500);
                    } else if (data.status === 'failed') {
                        document.getElementById('statusText').textContent = 'Pembayaran gagal. Silakan coba lagi.';
                        document.getElementById('statusIndicator').classList.remove('text-gray-500');
                        document.getElementById('statusIndicator').classList.add('text-red-600');
                    } else {
                        // Still pending, check again
                        setTimeout(checkPaymentStatus, 3000);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    setTimeout(checkPaymentStatus, 5000);
                });
        }

        // Start polling after 2 seconds
        setTimeout(checkPaymentStatus, 2000);
    </script>
</x-customer-layout>
