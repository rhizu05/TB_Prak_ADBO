<x-app-layout>
    <x-slot name="header">
        Kitchen Dashboard
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Queue Card -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="font-bold text-gray-500 text-sm">Orders in Queue</h3>
            <p class="text-3xl font-bold text-orange-500 mt-2">{{ $queueCount }}</p>
            <p class="text-xs text-gray-400 mt-1">Waiting to be cooked</p>
        </div>

        <!-- Completed Card -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="font-bold text-gray-500 text-sm">Completed Today</h3>
            <p class="text-3xl font-bold text-green-500 mt-2">{{ $completedToday }}</p>
            <p class="text-xs text-gray-400 mt-1">Orders marked as ready</p>
        </div>
    </div>
    
    <div class="mt-8 bg-blue-50 rounded-xl p-6 border border-blue-100 text-center">
        <h3 class="font-bold text-blue-800 mb-2">Ready to Cook?</h3>
        <p class="text-blue-600 mb-4 text-sm">Open the Kitchen Display System to manage active orders.</p>
        <a href="{{ route('koki.kds.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow transition">
            Open KDS
        </a>
    </div>
</x-app-layout>
