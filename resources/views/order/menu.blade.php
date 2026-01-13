<x-customer-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center text-white">
            <div>
                <h2 class="text-xl font-bold">Table #{{ session('table_number') }}</h2>
                <p class="text-blue-200 text-sm">Welcome to RestoQR</p>
            </div>
            <a href="{{ route('cart.view') }}" class="relative inline-flex items-center p-3 text-sm font-medium text-center text-blue-700 bg-white rounded-xl shadow hover:bg-blue-50 focus:ring-4 focus:outline-none focus:ring-blue-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                @php $cartCount = count(session('cart', [])); @endphp
                @if($cartCount > 0)
                    <div class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -right-2">{{ $cartCount }}</div>
                @endif
            </a>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl shadow-sm relative z-10" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Search Bar -->
    <div class="relative mb-8 z-10">
        <input type="text" id="searchInput" class="w-full bg-white rounded-xl py-3 px-4 pl-12 shadow-sm border border-gray-100 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Cari menu favorit...">
        <div class="absolute left-4 top-3 text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
    </div>

    <!-- No Results Message -->
    <div id="noResults" class="hidden text-center py-10 text-gray-500">
        <div class="text-4xl mb-2">🔍</div>
        <p>Menu tidak ditemukan</p>
    </div>

    <div id="menuContainer" class="space-y-8 pb-12">
        @foreach($categories as $category)
            @if($category->products->isNotEmpty())
                <div id="category-{{ $category->id }}" class="category-section">
                    <h3 class="category-title text-lg font-bold text-gray-800 mb-3 px-1 flex items-center gap-2">
                        <span class="w-1 h-6 bg-blue-600 rounded-full"></span>
                        {{ $category->name }}
                    </h3>
                    <div class="grid grid-cols-1 gap-4">
                        @foreach($category->products as $product)
                            <div class="product-card bg-white rounded-xl shadow-sm border border-gray-100 p-3 flex gap-4" data-name="{{ strtolower($product->name) }}" data-description="{{ strtolower($product->description) }}">
                                <div class="w-24 h-24 flex-shrink-0 bg-gray-100 rounded-lg overflow-hidden">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-xs text-gray-400">No Image</div>
                                    @endif
                                </div>
                                <div class="flex-1 flex flex-col justify-between py-1">
                                    <div>
                                        <h4 class="font-bold text-gray-900 line-clamp-1 text-base">{{ $product->name }}</h4>
                                        <p class="text-xs text-gray-500 line-clamp-2 mt-1 leading-relaxed">{{ $product->description }}</p>
                                    </div>
                                    <div class="flex justify-between items-center mt-3">
                                        <p class="text-blue-600 font-bold text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                        
                                        <form action="{{ route('cart.add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 active:scale-95 text-white text-xs font-bold py-2 px-4 rounded-lg shadow-md transition-all">
                                                Add
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <script>
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            const products = document.querySelectorAll('.product-card');
            const categories = document.querySelectorAll('.category-section');
            let totalVisible = 0;

            products.forEach(product => {
                const name = product.dataset.name || '';
                const description = product.dataset.description || '';
                const matches = name.includes(searchTerm) || description.includes(searchTerm);
                product.style.display = matches ? 'flex' : 'none';
                if (matches) totalVisible++;
            });

            // Hide empty categories
            categories.forEach(category => {
                const visibleProducts = category.querySelectorAll('.product-card[style="display: flex;"], .product-card:not([style])');
                let hasVisible = false;
                visibleProducts.forEach(p => {
                    if (p.style.display !== 'none') hasVisible = true;
                });
                
                const visibleCount = Array.from(category.querySelectorAll('.product-card')).filter(p => p.style.display !== 'none').length;
                category.style.display = visibleCount > 0 ? 'block' : 'none';
            });

            // Show/hide no results message
            document.getElementById('noResults').style.display = totalVisible === 0 ? 'block' : 'none';
            document.getElementById('menuContainer').style.display = totalVisible === 0 ? 'none' : 'block';
        });
    </script>
</x-customer-layout>
