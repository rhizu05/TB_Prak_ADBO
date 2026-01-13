<x-app-layout>
    <x-slot name="header">
        Create Table
    </x-slot>

    <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-sm border border-gray-100">
        <form method="POST" action="{{ route('admin.tables.store') }}">
            @csrf
            
            <div class="mb-5">
                <label for="number" class="block mb-2 text-sm font-medium text-gray-900">Table Number</label>
                <input type="number" id="number" name="number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="e.g. 1" required autofocus>
                <p class="mt-2 text-xs text-gray-500">QR Code will be generated automatically for this number.</p>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.tables.index') }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5">Cancel</a>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">Save Table</button>
            </div>
        </form>
    </div>
</x-app-layout>
