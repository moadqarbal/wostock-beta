<x-layout>
    <div class="lg:ml-72 min-h-screen flex flex-col transition-all duration-300">
        {{-- Topbar --}}
        <x-navigation.topbar />
        <main class="flex-1 p-4 md:p-6 lg:p-8">
            {{-- Page Header --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">
                        Produits
                    </h1>
                    <p class="text-sm text-slate-500 mt-1">
                        Gérez votre catalogue de produits et votre stock.
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    {{-- Produits supprimés --}}
                    <a href="{{ route('products.trashed') }}"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition-all">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                        Produits supprimés
                    </a>

                    {{-- Ajouter un produit --}}
                    <a href="{{ route('products.create') }}"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-all">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        Ajouter un produit
                    </a>
                </div>
            </div>
            {{-- Search & Filters --}}
            <form method="GET" action="{{ route('products.index') }}"
                class="bg-white border border-slate-200 rounded-t-2xl p-4 flex flex-col md:flex-row gap-4 justify-between items-center">
                {{-- Search --}}
                <div class="relative w-full md:w-96">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                    <input type="text" id="productSearch" name="search" value="{{ request('search') }}"
                        placeholder="Rechercher par nom, SKU ou fournisseur..." autocomplete="off"
                        class="w-full pl-10 pr-10 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm transition-all bg-slate-50/50">
                    <button type="button" id="clearSearch"
                        class="hidden absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
                {{-- Stock Filter --}}
                <div class="flex items-center gap-2 w-full md:w-auto">
                    <select id="stockFilter" name="stock" onchange="this.form.submit()"
                        class="bg-white border border-slate-200 text-slate-600 text-sm rounded-xl px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">
                            Tous les stocks
                        </option>
                        <option value="disponible" {{ request('stock') === 'disponible' ? 'selected' : '' }}>
                            En Stock
                        </option>
                        <option value="faible" {{ request('stock') === 'faible' ? 'selected' : '' }}>
                            Stock Faible
                        </option>
                        <option value="rupture" {{ request('stock') === 'rupture' ? 'selected' : '' }}>
                            Rupture
                        </option>
                    </select>
                </div>
            </form>
            {{-- Products Table --}}
            <div class="bg-white border-x border-b border-slate-200 rounded-b-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        {{-- Table Header --}}
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="text-left px-6 py-4 font-semibold text-slate-600">
                                    Produit
                                </th>
                                <th class="text-left px-6 py-4 font-semibold text-slate-600">
                                    SKU
                                </th>
                                <th class="text-left px-6 py-4 font-semibold text-slate-600">
                                    Prix
                                </th>
                                <th class="text-left px-6 py-4 font-semibold text-slate-600">
                                    Stock
                                </th>
                                <th class="text-left px-6 py-4 font-semibold text-slate-600">
                                    Fournisseur
                                </th>
                                <th class="text-right px-6 py-4 font-semibold text-slate-600">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        {{-- Table Body --}}
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($products as $product)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    {{-- Product --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center shrink-0">
                                                <i data-lucide="package" class="w-5 h-5 text-indigo-600"></i>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-slate-800">
                                                    {{ $product->name }}
                                                </p>
                                                @if ($product->category)
                                                    <p class="text-xs text-slate-400 mt-0.5">
                                                        {{ $product->category->name }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    {{-- SKU --}}
                                    <td class="px-6 py-4">
                                        <span class="font-mono text-xs text-slate-600">
                                            {{ $product->sku }}
                                        </span>
                                    </td>
                                    {{-- Price --}}
                                    <td class="px-6 py-4">
                                        <span class="font-semibold text-slate-800">
                                            {{ number_format($product->price, 2) }} DH
                                        </span>
                                    </td>
                                    {{-- Stock --}}
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col gap-1">
                                            <div class="flex items-center gap-2">
                                                <span class="font-semibold text-slate-800">
                                                    {{ $product->stock_quantity }}
                                                </span>
                                                @if ($product->stock_quantity == 0)
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-semibold bg-red-50 text-red-600">
                                                        Rupture
                                                    </span>
                                                @elseif ($product->stock_quantity <= $product->minimum_stock)
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-semibold bg-amber-50 text-amber-600">
                                                        Faible
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-semibold bg-emerald-50 text-emerald-600">
                                                        OK
                                                    </span>
                                                @endif
                                            </div>
                                            <span class="text-xs text-slate-400">
                                                Min : {{ $product->minimum_stock }}
                                            </span>
                                        </div>
                                    </td>
                                    {{-- Supplier --}}
                                    <td class="px-6 py-4">
                                        @if ($product->supplier)
                                            <span class="text-slate-600">
                                                {{ $product->supplier->company_name }}
                                            </span>
                                        @else
                                            <span class="text-slate-400">
                                                —
                                            </span>
                                        @endif
                                    </td>
                                    {{-- Actions --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            {{-- View --}}
                                            <a href="{{ route('products.show', $product) }}" title="Voir"
                                                class="w-9 h-9 flex items-center justify-center rounded-lg text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 transition-all">
                                                <i data-lucide="eye" class="w-4 h-4"></i>
                                            </a>
                                            {{-- Edit --}}
                                            <a href="{{ route('products.edit', $product) }}" title="Modifier"
                                                class="w-9 h-9 flex items-center justify-center rounded-lg text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 transition-all">
                                                <i data-lucide="pencil" class="w-4 h-4"></i>
                                            </a>
                                            {{-- Delete --}}
                                            <form action="{{ route('products.destroy', $product) }}" method="POST"
                                                onsubmit="return confirm('Voulez-vous vraiment supprimer ce produit ?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="w-9 h-9 flex items-center justify-center rounded-lg text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 transition-all">
                                                    <i data-lucide="trash" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                {{-- Empty State --}}
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div
                                                class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center mb-4">
                                                <i data-lucide="package-x" class="w-7 h-7 text-slate-400"></i>
                                            </div>
                                            <h3 class="font-semibold text-slate-700">
                                                Aucun produit trouvé
                                            </h3>
                                            <p class="text-sm text-slate-400 mt-1">
                                                Aucun produit ne correspond à votre recherche.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- Footer --}}
                <div
                    class="p-4 border-t border-slate-100 bg-slate-50/50 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    {{-- Results Count --}}
                    <p data-results-count class="text-sm text-slate-500">
                        Affichage de
                        @if ($products->total() > 0)
                            <span class="font-bold text-slate-800">
                                {{ $products->firstItem() }}-{{ $products->lastItem() }}
                            </span>
                        @else
                            <span class="font-bold text-slate-800">
                                0
                            </span>
                        @endif
                        sur
                        <span class="font-bold text-slate-800">
                            {{ $products->total() }}
                        </span>
                        produits
                    </p>
                    {{-- Pagination --}}
                    <div data-pagination class="flex items-center gap-1">
                        @if ($products->hasPages())
                            {{-- Previous --}}
                            @if ($products->onFirstPage())
                                <span
                                    class="w-9 h-9 flex items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-300">
                                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                                </span>
                            @else
                                <a href="{{ $products->previousPageUrl() }}" data-pagination-link
                                    class="w-9 h-9 flex items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 hover:border-indigo-200 transition-all">
                                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                                </a>
                            @endif
                            {{-- Page Numbers --}}
                            @php
                                $currentPage = $products->currentPage();
                                $lastPage = $products->lastPage();
                                if ($lastPage <= 7) {
                                    $pages = range(1, $lastPage);
                                } elseif ($currentPage <= 4) {
                                    $pages = [1, 2, 3, 4, 5, '...', $lastPage];
                                } elseif ($currentPage >= $lastPage - 3) {
                                    $pages = [
                                        1,
                                        '...',
                                        $lastPage - 4,
                                        $lastPage - 3,
                                        $lastPage - 2,
                                        $lastPage - 1,
                                        $lastPage,
                                    ];
                                } else {
                                    $pages = [
                                        1,
                                        '...',
                                        $currentPage - 1,
                                        $currentPage,
                                        $currentPage + 1,
                                        '...',
                                        $lastPage,
                                    ];
                                }
                            @endphp
                            @foreach ($pages as $page)
                                @if ($page === '...')
                                    <span class="w-9 h-9 flex items-center justify-center text-slate-400 text-sm">
                                        ...
                                    </span>
                                @elseif ($page == $currentPage)
                                    <span
                                        class="w-9 h-9 flex items-center justify-center rounded-lg bg-indigo-600 text-white text-sm font-semibold shadow-sm">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $products->url($page) }}" data-pagination-link
                                        class="w-9 h-9 flex items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 text-sm hover:text-indigo-600 hover:bg-indigo-50 hover:border-indigo-200 transition-all">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                            {{-- Next --}}
                            @if ($products->hasMorePages())
                                <a href="{{ $products->nextPageUrl() }}" data-pagination-link
                                    class="w-9 h-9 flex items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 hover:border-indigo-200 transition-all">
                                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                                </a>
                            @else
                                <span
                                    class="w-9 h-9 flex items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-300">
                                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                                </span>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>
    {{-- AJAX Search + Pagination --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput =
                document.getElementById('productSearch');
            const clearSearch =
                document.getElementById('clearSearch');
            const stockFilter =
                document.getElementById('stockFilter');
            let searchTimeout = null;
            /*
            |--------------------------------------------------------------------------
            | Helpers
            |--------------------------------------------------------------------------
            */
            function refreshIcons() {
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            }

            function updateClearButton() {
                if (searchInput.value.trim() === '') {
                    clearSearch.classList.add('hidden');
                } else {
                    clearSearch.classList.remove('hidden');
                }
            }
            /*
            |--------------------------------------------------------------------------
            | AJAX Load
            |--------------------------------------------------------------------------
            */
            function loadProducts(url, keepFocus = false) {
                fetch(url, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('HTTP error ' + response.status);
                        }
                        return response.text();
                    })
                    .then(html => {
                        const parser =
                            new DOMParser();
                        const doc =
                            parser.parseFromString(
                                html,
                                'text/html'
                            );
                        /*
                        |--------------------------------------------------------------------------
                        | Replace table body
                        |--------------------------------------------------------------------------
                        */
                        const newTableBody =
                            doc.querySelector('table tbody');
                        const currentTableBody =
                            document.querySelector('table tbody');
                        if (
                            newTableBody &&
                            currentTableBody
                        ) {
                            currentTableBody.innerHTML =
                                newTableBody.innerHTML;
                        }
                        /*
                        |--------------------------------------------------------------------------
                        | Replace results count
                        |--------------------------------------------------------------------------
                        */
                        const newResults =
                            doc.querySelector(
                                '[data-results-count]'
                            );
                        const currentResults =
                            document.querySelector(
                                '[data-results-count]'
                            );
                        if (
                            newResults &&
                            currentResults
                        ) {
                            currentResults.innerHTML =
                                newResults.innerHTML;
                        }
                        /*
                        |--------------------------------------------------------------------------
                        | Replace pagination COMPLETELY
                        |--------------------------------------------------------------------------
                        */
                        const newPagination =
                            doc.querySelector(
                                '[data-pagination]'
                            );
                        const currentPagination =
                            document.querySelector(
                                '[data-pagination]'
                            );
                        if (newPagination && currentPagination) {
                            currentPagination.replaceWith(
                                newPagination
                            );
                        }
                        /*
                        |--------------------------------------------------------------------------
                        | If new result has NO pagination
                        |--------------------------------------------------------------------------
                        */
                        if (!newPagination && currentPagination) {
                            currentPagination.innerHTML = '';
                        }
                        /*
                        |--------------------------------------------------------------------------
                        | Update URL
                        |--------------------------------------------------------------------------
                        */
                        window.history.replaceState({},
                            '',
                            url
                        );
                        /*
                        |--------------------------------------------------------------------------
                        | Keep input focused
                        |--------------------------------------------------------------------------
                        */
                        if (keepFocus) {
                            searchInput.focus();
                            const position =
                                searchInput.value.length;
                            searchInput.setSelectionRange(
                                position,
                                position
                            );
                        }
                        refreshIcons();
                    })
                    .catch(error => {
                        console.error(
                            'Products AJAX error:',
                            error
                        );
                    });
            }
            /*
            |--------------------------------------------------------------------------
            | Live Search
            |--------------------------------------------------------------------------
            */
            searchInput.addEventListener(
                'input',
                function() {
                    clearTimeout(searchTimeout);
                    updateClearButton();
                    searchTimeout = setTimeout(
                        function() {
                            const url =
                                new URL(
                                    '{{ route('products.index') }}',
                                    window.location.origin
                                );
                            const search =
                                searchInput.value.trim();
                            /*
                            |--------------------------------------------------------------------------
                            | Search
                            |--------------------------------------------------------------------------
                            */
                            if (search !== '') {
                                url.searchParams.set(
                                    'search',
                                    search
                                );
                            }
                            /*
                            |--------------------------------------------------------------------------
                            | Stock
                            |--------------------------------------------------------------------------
                            */
                            if (
                                stockFilter &&
                                stockFilter.value !== ''
                            ) {
                                url.searchParams.set(
                                    'stock',
                                    stockFilter.value
                                );
                            }
                            /*
                            |--------------------------------------------------------------------------
                            | Always reset page
                            |--------------------------------------------------------------------------
                            */
                            url.searchParams.delete(
                                'page'
                            );
                            loadProducts(
                                url.toString(),
                                true
                            );
                        },
                        400
                    );
                }
            );
            /*
            |--------------------------------------------------------------------------
            | Pagination Click
            |--------------------------------------------------------------------------
            */
            document.addEventListener(
                'click',
                function(event) {
                    const link =
                        event.target.closest(
                            '[data-pagination-link]'
                        );
                    if (!link) {
                        return;
                    }
                    event.preventDefault();
                    loadProducts(
                        link.href,
                        true
                    );
                }
            );
            /*
            |--------------------------------------------------------------------------
            | Clear Search
            |--------------------------------------------------------------------------
            */
            clearSearch.addEventListener(
                'click',
                function() {
                    clearTimeout(searchTimeout);
                    searchInput.value = '';
                    updateClearButton();
                    const url =
                        new URL(
                            '{{ route('products.index') }}',
                            window.location.origin
                        );
                    /*
                    |--------------------------------------------------------------------------
                    | Keep stock filter
                    |--------------------------------------------------------------------------
                    */
                    if (
                        stockFilter &&
                        stockFilter.value !== ''
                    ) {
                        url.searchParams.set(
                            'stock',
                            stockFilter.value
                        );
                    }
                    url.searchParams.delete('page');
                    loadProducts(
                        url.toString(),
                        true
                    );
                }
            );
            /*
            |--------------------------------------------------------------------------
            | Initial
            |--------------------------------------------------------------------------
            */
            updateClearButton();
            refreshIcons();
        });
    </script>
</x-layout>
