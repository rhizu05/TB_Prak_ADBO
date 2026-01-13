<x-app-layout>
    <x-slot name="header">
        Edit Category
    </x-slot>

    <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-sm border border-gray-100">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}">
            @csrf
            @method('PUT')
            
            <div class="mb-5">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Category Name</label>
                <input type="text" id="name" name="name" value="{{ $category->name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
            </div>

            <div class="mb-5">
                <label for="type" class="block mb-2 text-sm font-medium text-gray-900">Type</label>
                <select id="type" name="type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                    <option value="makanan" {{ $category->type === 'makanan' ? 'selected' : '' }}>Makanan</option>
                    <option value="minuman" {{ $category->type === 'minuman' ? 'selected' : '' }}>Minuman</option>
                    <option value="snack" {{ $category->type === 'snack' ? 'selected' : '' }}>Snack</option>
                </select>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.categories.index') }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5">Cancel</a>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">Update Category</button>
            </div>
        </form>
    </div>
</x-app-layout>
