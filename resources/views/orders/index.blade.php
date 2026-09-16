<x-layout>
    <div class="lg:ml-72 min-h-screen flex flex-col transition-all duration-300">
        {{-- Topbar --}}
        <x-navigation.topbar />
        <main class="flex-1 p-4 md:p-6 lg:p-8">
            {{-- Page Header --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">
                        Gestion des commandes
                    </h1>
                    <p class="text-sm text-slate-500 mt-1">
                        Suivez et gérez l'état de vos ventes en temps réel.
                    </p>
                </div>
                <a href="{{ route('orders.create') }}"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-all">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Nouvelle commande
                </a>
            </div>
            {{-- Stats --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
                {{-- Pending --}}
                <div class="bg-white border border-slate-200 rounded-2xl p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500">
                                En attente
                            </p>
                            <p class="text-2xl font-bold text-slate-800 mt-1">
                                {{ str_pad($pendingCount, 2, '0', STR_PAD_LEFT) }}
                            </p>
                        </div>
                        <div class="w-11 h-11 rounded-xl bg-amber-50 flex items-center justify-center">
                            <i data-lucide="clock" class="w-5 h-5 text-amber-600"></i>
                        </div>
                    </div>
                </div>
                {{-- Shipped --}}
                <div class="bg-white border border-slate-200 rounded-2xl p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500">
                                Expédiées
                            </p>
                            <p class="text-2xl font-bold text-slate-800 mt-1">
                                {{ str_pad($shippedCount, 2, '0', STR_PAD_LEFT) }}
                            </p>
                        </div>
                        <div class="w-11 h-11 rounded-xl bg-indigo-50 flex items-center justify-center">
                            <i data-lucide="truck" class="w-5 h-5 text-indigo-600"></i>
                        </div>
                    </div>
                </div>
                {{-- Today --}}
                <div class="bg-white border border-slate-200 rounded-2xl p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500">
                                Aujourd'hui
                            </p>
                            <p class="text-2xl font-bold text-slate-800 mt-1">
                                {{ number_format($todayTotal, 2, ',', ' ') }} DH
                            </p>
                        </div>
                        <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center">
                            <i data-lucide="banknote" class="w-5 h-5 text-emerald-600"></i>
                        </div>
                    </div>
                </div>
                {{-- Delivered --}}
                <div class="bg-white border border-slate-200 rounded-2xl p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500">
                                Livrées
                            </p>
                            <p class="text-2xl font-bold text-slate-800 mt-1">
                                {{ str_pad($deliveredCount, 2, '0', STR_PAD_LEFT) }}
                            </p>
                        </div>
                        <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center">
                            <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600"></i>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Search & Filters --}}
            <div
                class="bg-white border border-slate-200 rounded-t-2xl p-4 flex flex-col md:flex-row gap-4 justify-between items-center">
                {{-- Search --}}
                <div class="relative w-full md:w-96">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                    <input type="text" id="orderSearch" name="search" value="{{ request('search') }}"
                        placeholder="N° commande ou client..." autocomplete="off"
                        class="w-full pl-10 pr-10 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm transition-all bg-slate-50/50">
                    <button type="button" id="clearSearch"
                        class="hidden absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
                {{-- Filters --}}
                <div class="flex flex-col sm:flex-row items-center gap-2 w-full md:w-auto">
                    {{-- Status --}}
                    <select id="statusFilter" name="status"
                        class="w-full sm:w-auto bg-white border border-slate-200 text-slate-600 text-sm rounded-xl px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">
                            Tous les statuts
                        </option>
                        <option value="En attente" {{ request('status') === 'En attente' ? 'selected' : '' }}>
                            En attente
                        </option>
                        <option value="Confirmée" {{ request('status') === 'Confirmée' ? 'selected' : '' }}>
                            Confirmée
                        </option>
                        <option value="Expédiée" {{ request('status') === 'Expédiée' ? 'selected' : '' }}>
                            Expédiée
                        </option>
                        <option value="Livrée" {{ request('status') === 'Livrée' ? 'selected' : '' }}>
                            Livrée
                        </option>
                        <option value="Annulée" {{ request('status') === 'Annulée' ? 'selected' : '' }}>
                            Annulée
                        </option>
                        <option value="Retournée" {{ request('status') === 'Retournée' ? 'selected' : '' }}>
                            Retournée
                        </option>
                    </select>
                    {{-- Source --}}
                    <select id="sourceFilter" name="source"
                        class="w-full sm:w-auto bg-white border border-slate-200 text-slate-600 text-sm rounded-xl px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">
                            Toutes les sources
                        </option>
                        <option value="manuelle" {{ request('source') === 'manuelle' ? 'selected' : '' }}>
                            Manuelle
                        </option>
                        <option value="whatsapp" {{ request('source') === 'whatsapp' ? 'selected' : '' }}>
                            WhatsApp
                        </option>
                        <option value="site_web" {{ request('source') === 'site_web' ? 'selected' : '' }}>
                            Site web
                        </option>
                        <option value="woocommerce" {{ request('source') === 'woocommerce' ? 'selected' : '' }}>
                            WooCommerce
                        </option>
                    </select>
                </div>
            </div>
            {{-- Orders Table --}}
            <div class="bg-white border-x border-b border-slate-200 rounded-b-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        {{-- Table Header --}}
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="text-left px-6 py-4 font-semibold text-slate-600">
                                    N° Commande
                                </th>
                                <th class="text-left px-6 py-4 font-semibold text-slate-600">
                                    Client
                                </th>
                                <th class="text-left px-6 py-4 font-semibold text-slate-600">
                                    Produits
                                </th>
                                <th class="text-left px-6 py-4 font-semibold text-slate-600">
                                    Source
                                </th>
                                <th class="text-left px-6 py-4 font-semibold text-slate-600">
                                    Total
                                </th>
                                <th class="text-left px-6 py-4 font-semibold text-slate-600">
                                    Statut
                                </th>
                                <th class="text-right px-6 py-4 font-semibold text-slate-600">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        {{-- Table Body --}}
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($orders as $order)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    {{-- Order --}}
                                    <td class="px-6 py-4">
                                        <div>
                                            <p class="font-semibold text-slate-800">
                                                #{{ $order->order_number }}
                                            </p>
                                            <p class="text-xs text-slate-400 mt-0.5">
                                                {{ $order->created_at->format('d/m/Y H:i') }}
                                            </p>
                                        </div>
                                    </td>
                                    {{-- Client --}}
                                    <td class="px-6 py-4">
                                        @if ($order->client)
                                            <div>
                                                <p class="font-semibold text-slate-800">
                                                    {{ $order->client->name }}
                                                </p>
                                                @if ($order->client->phone)
                                                    <p class="text-xs text-slate-400 mt-0.5">
                                                        {{ $order->client->phone }}
                                                    </p>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-slate-400">
                                                Client supprimé
                                            </span>
                                        @endif
                                    </td>
                                    {{-- Products --}}
                                    <td class="px-6 py-4">
                                        <div class="max-w-xs space-y-1">
                                            @forelse ($order->items as $item)
                                                <p class="text-slate-600">
                                                    {{ $item->product?->name ?? 'Produit supprimé' }}
                                                    <span class="text-slate-400">
                                                        (x{{ $item->quantity }})
                                                    </span>
                                                </p>
                                            @empty
                                                <span class="text-slate-400">
                                                    Aucun produit
                                                </span>
                                            @endforelse
                                        </div>
                                    </td>
                                    {{-- Source --}}
                                    <td class="px-6 py-4">
                                        @php
                                            $sourceLabels = [
                                                'manuelle' => 'Manuelle',
                                                'whatsapp' => 'WhatsApp',
                                                'site_web' => 'Site web',
                                                'woocommerce' => 'WooCommerce',
                                            ];
                                            $sourceClasses = [
                                                'manuelle' => 'bg-slate-100 text-slate-600',
                                                'whatsapp' => 'bg-emerald-50 text-emerald-600',
                                                'site_web' => 'bg-indigo-50 text-indigo-600',
                                                'woocommerce' => 'bg-purple-50 text-purple-600',
                                            ];
                                            $sourceIcons = [
                                                'manuelle' => 'pen-line',
                                                'whatsapp' => 'message-circle',
                                                'site_web' => 'globe',
                                                'woocommerce' => 'shopping-cart',
                                            ];
                                        @endphp
                                        <span
                                            class="inline-flex items-center gap-2 px-2.5 py-1 rounded-lg text-xs font-semibold {{ $sourceClasses[$order->source] ?? 'bg-slate-100 text-slate-600' }}">
                                            <i data-lucide="{{ $sourceIcons[$order->source] ?? 'file-text' }}"
                                                class="w-3.5 h-3.5"></i>
                                            {{ $sourceLabels[$order->source] ?? $order->source }}
                                        </span>
                                    </td>
                                    {{-- Total --}}
                                    <td class="px-6 py-4">
                                        <span class="font-semibold text-slate-800 whitespace-nowrap">
                                            {{ number_format($order->total_amount, 2, ',', ' ') }} DH
                                        </span>
                                    </td>
                                    {{-- Status --}}
                                    <td class="px-6 py-4">
                                        @php
                                            $statusLabels = [
                                                'En attente' => 'En attente',
                                                'Confirmée' => 'Confirmée',
                                                'Expédiée' => 'Expédiée',
                                                'Livrée' => 'Livrée',
                                                'Annulée' => 'Annulée',
                                                'Retournée' => 'Retournée',
                                            ];
                                            $statusClasses = [
                                                'En attente' => 'bg-amber-50 text-amber-600',
                                                'Confirmée' => 'bg-blue-50 text-blue-600',
                                                'Expédiée' => 'bg-indigo-50 text-indigo-600',
                                                'Livrée' => 'bg-emerald-50 text-emerald-600',
                                                'Annulée' => 'bg-red-50 text-red-600',
                                                'Retournée' => 'bg-slate-100 text-slate-600',
                                            ];
                                            $statusIcons = [
                                                'En attente' => 'clock',
                                                'Confirmée' => 'circle-check',
                                                'Expédiée' => 'truck',
                                                'Livrée' => 'check-circle',
                                                'Annulée' => 'circle-x',
                                                'Retournée' => 'rotate-ccw',
                                            ];
                                        @endphp
                                        <span
                                            class="inline-flex items-center gap-2 px-2.5 py-1 rounded-lg text-xs font-semibold {{ $statusClasses[$order->status] ?? 'bg-slate-100 text-slate-600' }}">
                                            <i data-lucide="{{ $statusIcons[$order->status] ?? 'circle' }}"
                                                class="w-3.5 h-3.5"></i>
                                            {{ $statusLabels[$order->status] ?? $order->status }}
                                        </span>
                                    </td>
                                    {{-- Actions --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            {{-- View --}}
                                            <a href="{{ route('orders.show', $order) }}" title="Voir"
                                                class="w-9 h-9 flex items-center justify-center rounded-lg text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 transition-all">
                                                <i data-lucide="eye" class="w-4 h-4"></i>
                                            </a>
                                            {{-- Edit --}}
                                            <a href="{{ route('orders.edit', $order) }}" title="Modifier"
                                                class="w-9 h-9 flex items-center justify-center rounded-lg text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 transition-all">
                                                <i data-lucide="pencil" class="w-4 h-4"></i>
                                            </a>
                                            {{-- Delete --}}
                                            <form action="{{ route('orders.destroy', $order) }}" method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" title="Supprimer"
                                                    onclick="return confirm('Voulez-vous vraiment supprimer cette commande ?')"
                                                    class="w-9 h-9 flex items-center justify-center rounded-lg text-slate-500 hover:text-red-600 hover:bg-red-50 transition-all">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div
                                                class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center mb-4">
                                                <i data-lucide="shopping-bag" class="w-7 h-7 text-slate-400"></i>
                                            </div>
                                            <h3 class="font-semibold text-slate-700">
                                                Aucune commande trouvée
                                            </h3>
                                            <p class="text-sm text-slate-400 mt-1">
                                                Aucune commande ne correspond à votre recherche.
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
                        @if ($orders->total() > 0)
                            <span class="font-bold text-slate-800">
                                {{ $orders->firstItem() }}-{{ $orders->lastItem() }}
                            </span>
                        @else
                            <span class="font-bold text-slate-800">
                                0
                            </span>
                        @endif
                        sur
                        <span class="font-bold text-slate-800">
                            {{ $orders->total() }}
                        </span>
                        commandes
                    </p>
                    {{-- Pagination --}}
                    <div data-pagination class="flex items-center gap-1">
                        @if ($orders->hasPages())
                            {{-- Previous --}}
                            @if ($orders->onFirstPage())
                                <span
                                    class="w-9 h-9 flex items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-300">
                                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                                </span>
                            @else
                                <a href="{{ $orders->previousPageUrl() }}" data-pagination-link
                                    class="w-9 h-9 flex items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 hover:border-indigo-200 transition-all">
                                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                                </a>
                            @endif
                            {{-- Page Numbers --}}
                            @php
                                $currentPage = $orders->currentPage();
                                $lastPage = $orders->lastPage();
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
                                    <a href="{{ $orders->url($page) }}" data-pagination-link
                                        class="w-9 h-9 flex items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 text-sm hover:text-indigo-600 hover:bg-indigo-50 hover:border-indigo-200 transition-all">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                            {{-- Next --}}
                            @if ($orders->hasMorePages())
                                <a href="{{ $orders->nextPageUrl() }}" data-pagination-link
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
    {{-- AJAX Search + Filters + Pagination --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput =
                document.getElementById('orderSearch');
            const clearSearch =
                document.getElementById('clearSearch');
            const statusFilter =
                document.getElementById('statusFilter');
            const sourceFilter =
                document.getElementById('sourceFilter');
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
            | Build URL
            |--------------------------------------------------------------------------
            */
            function buildUrl() {
                const url =
                    new URL(
                        '{{ route('orders.index') }}',
                        window.location.origin
                    );
                const search =
                    searchInput.value.trim();
                const status =
                    statusFilter.value;
                const source =
                    sourceFilter.value;
                if (search !== '') {
                    url.searchParams.set(
                        'search',
                        search
                    );
                }
                if (status !== '') {
                    url.searchParams.set(
                        'status',
                        status
                    );
                }
                if (source !== '') {
                    url.searchParams.set(
                        'source',
                        source
                    );
                }
                url.searchParams.delete('page');
                return url.toString();
            }
            /*
            |--------------------------------------------------------------------------
            | AJAX Load
            |--------------------------------------------------------------------------
            */
            function loadOrders(
                url,
                keepFocus = false
            ) {
                fetch(url, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(
                                'HTTP error ' +
                                response.status
                            );
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
                        | Replace Table Body
                        |--------------------------------------------------------------------------
                        */
                        const newTableBody =
                            doc.querySelector(
                                'table tbody'
                            );
                        const currentTableBody =
                            document.querySelector(
                                'table tbody'
                            );
                        if (
                            newTableBody &&
                            currentTableBody
                        ) {
                            currentTableBody.innerHTML =
                                newTableBody.innerHTML;
                        }
                        /*
                        |--------------------------------------------------------------------------
                        | Replace Results Count
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
                        | Replace Pagination
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
                        if (
                            newPagination &&
                            currentPagination
                        ) {
                            currentPagination.replaceWith(
                                newPagination
                            );
                        }
                        if (
                            !newPagination &&
                            currentPagination
                        ) {
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
                        | Keep Search Focus
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
                            'Orders AJAX error:',
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
                    clearTimeout(
                        searchTimeout
                    );
                    updateClearButton();
                    searchTimeout =
                        setTimeout(
                            function() {
                                loadOrders(
                                    buildUrl(),
                                    true
                                );
                            },
                            400
                        );
                }
            );
            /*
            |--------------------------------------------------------------------------
            | Status Filter
            |--------------------------------------------------------------------------
            */
            statusFilter.addEventListener(
                'change',
                function() {
                    loadOrders(
                        buildUrl(),
                        false
                    );
                }
            );
            /*
            |--------------------------------------------------------------------------
            | Source Filter
            |--------------------------------------------------------------------------
            */
            sourceFilter.addEventListener(
                'change',
                function() {
                    loadOrders(
                        buildUrl(),
                        false
                    );
                }
            );
            /*
            |--------------------------------------------------------------------------
            | Pagination
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
                    loadOrders(
                        link.href,
                        false
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
                    clearTimeout(
                        searchTimeout
                    );
                    searchInput.value = '';
                    updateClearButton();
                    loadOrders(
                        buildUrl(),
                        true
                    );
                }
            );
            /*
            |--------------------------------------------------------------------------
            | Initialisation
            |--------------------------------------------------------------------------
            */
            updateClearButton();
            refreshIcons();
        });
    </script>
</x-layout>
