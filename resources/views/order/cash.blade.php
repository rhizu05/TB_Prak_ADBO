<x-customer-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center text-white">
            <h2 class="text-xl font-bold">Pembayaran Tunai</h2>
            <span class="text-sm bg-white/20 px-3 py-1 rounded-full">#{{ $order->id }}</span>
        </div>
    </x-slot>

    <div class="text-center py-6">
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <!-- Cash Icon -->
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-green-100 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>

            <h3 class="text-xl font-bold text-gray-800 mb-2">Silakan Bayar di Kasir</h3>
            <p class="text-sm text-gray-500 mb-6">Tunjukkan nomor pesanan ini kepada kasir</p>
            
            <!-- Order Number -->
            <div class="bg-blue-50 rounded-xl p-6 mb-6">
                <p class="text-sm text-gray-600 mb-1">Nomor Pesanan</p>
                <p class="text-4xl font-bold text-blue-600">#{{ $order->id }}</p>
            </div>

            <!-- Amount to Pay -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <p class="text-sm text-gray-600">Total yang harus dibayar</p>
                <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
            </div>

            <!-- Table Info -->
            <div class="flex items-center justify-center gap-2 text-gray-500 mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Meja {{ session('table_number') }}</span>
            </div>

            <!-- Instructions -->
            <div class="border-t border-gray-100 pt-6">
                <h4 class="font-semibold text-gray-700 mb-3">Instruksi:</h4>
                <ol class="text-sm text-gray-600 text-left space-y-2">
                    <li class="flex items-start gap-2">
                        <span class="bg-blue-100 text-blue-600 rounded-full w-5 h-5 flex-shrink-0 flex items-center justify-center text-xs font-bold">1</span>
                        <span>Datang ke meja kasir</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="bg-blue-100 text-blue-600 rounded-full w-5 h-5 flex-shrink-0 flex items-center justify-center text-xs font-bold">2</span>
                        <span>Sebutkan nomor pesanan <strong>#{{ $order->id }}</strong></span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="bg-blue-100 text-blue-600 rounded-full w-5 h-5 flex-shrink-0 flex items-center justify-center text-xs font-bold">3</span>
                        <span>Bayar sejumlah <strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="bg-blue-100 text-blue-600 rounded-full w-5 h-5 flex-shrink-0 flex items-center justify-center text-xs font-bold">4</span>
                        <span>Kembali ke meja dan tunggu pesanan Anda</span>
                    </li>
                </ol>
            </div>
        </div>

        <a href="{{ route('order.status', $order->id) }}" class="inline-flex items-center text-blue-600 font-semibold hover:text-blue-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            Lihat Status Pesanan
        </a>
    </div>
</x-customer-layout>
