<x-layout>
    <div class="lg:ml-72 min-h-screen flex flex-col transition-all duration-300">
        {{-- Topbar --}}
        <x-navigation.topbar />
        <main class="flex-1 p-4 md:p-6 lg:p-8">
            {{-- Page Header --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">
                        Produits supprimés
                    </h1>
                    <p class="text-sm text-slate-500 mt-1">
                        Gérez les produits placés dans la corbeille.
                    </p>
                </div>
                <a href="{{ route('products.index') }}"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition-all">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Retour aux produits
                </a>
            </div>
            {{-- Products Table --}}
            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
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
                                <th class="text-left px-6 py-4 font-semibold text-slate-600">
                                    Supprimé le
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
                                                class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center shrink-0">
                                                <i data-lucide="package"
                                                    class="w-5 h-5 text-slate-500"></i>
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
                                    {{-- Deleted At --}}
                                    <td class="px-6 py-4">
                                        <span class="text-sm text-slate-500">
                                            {{ $product->deleted_at->format('d/m/Y H:i') }}
                                        </span>
                                    </td>
                                    {{-- Actions --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            {{-- Restore --}}
                                            <form action="{{ route('products.restore', $product) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    title="Restaurer"
                                                    class="w-9 h-9 flex items-center justify-center rounded-lg text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 transition-all">
                                                    <i data-lucide="rotate-ccw"
                                                        class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                            {{-- Force Delete --}}
                                            <form action="{{ route('products.force-delete', $product) }}"
                                                method="POST"
                                                onsubmit="return confirm('Voulez-vous vraiment supprimer définitivement ce produit ? Cette action est irréversible.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    title="Supprimer définitivement"
                                                    class="w-9 h-9 flex items-center justify-center rounded-lg text-slate-500 hover:text-red-600 hover:bg-red-50 transition-all">
                                                    <i data-lucide="trash-2"
                                                        class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                {{-- Empty State --}}
                                <tr>
                                    <td colspan="7" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div
                                                class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center mb-4">
                                                <i data-lucide="trash-2"
                                                    class="w-7 h-7 text-slate-400"></i>
                                            </div>
                                            <h3 class="font-semibold text-slate-700">
                                                La corbeille est vide
                                            </h3>
                                            <p class="text-sm text-slate-400 mt-1">
                                                Aucun produit supprimé.
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
                    <p class="text-sm text-slate-500">
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
                        produits supprimés
                    </p>
                    {{-- Pagination --}}
                    <div class="flex items-center gap-1">
                        @if ($products->hasPages())
                            {{-- Previous --}}
                            @if ($products->onFirstPage())
                                <span
                                    class="w-9 h-9 flex items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-300">
                                    <i data-lucide="chevron-left"
                                        class="w-4 h-4"></i>
                                </span>
                            @else
                                <a href="{{ $products->previousPageUrl() }}"
                                    class="w-9 h-9 flex items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 hover:border-indigo-200 transition-all">
                                    <i data-lucide="chevron-left"
                                        class="w-4 h-4"></i>
                                </a>
                            @endif
                            {{-- Page Numbers --}}
                            @php
                                $currentPage = $products->currentPage();
                                $lastPage = $products->lastPage();
                                if ($lastPage <= 7) {
                                    $pages = range(1, $lastPage);
                                } elseif ($currentPage <= 4) {
                                    $pages = [
                                        1,
                                        2,
                                        3,
                                        4,
                                        5,
                                        '...',
                                        $lastPage
                                    ];
                                } elseif ($currentPage >= $lastPage - 3) {
                                    $pages = [
                                        1,
                                        '...',
                                        $lastPage - 4,
                                        $lastPage - 3,
                                        $lastPage - 2,
                                        $lastPage - 1,
                                        $lastPage
                                    ];
                                } else {
                                    $pages = [
                                        1,
                                        '...',
                                        $currentPage - 1,
                                        $currentPage,
                                        $currentPage + 1,
                                        '...',
                                        $lastPage
                                    ];
                                }
                            @endphp
                            @foreach ($pages as $page)
                                @if ($page === '...')
                                    <span
                                        class="w-9 h-9 flex items-center justify-center text-slate-400 text-sm">
                                        ...
                                    </span>
                                @elseif ($page == $currentPage)
                                    <span
                                        class="w-9 h-9 flex items-center justify-center rounded-lg bg-indigo-600 text-white text-sm font-semibold shadow-sm">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $products->url($page) }}"
                                        class="w-9 h-9 flex items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 text-sm hover:text-indigo-600 hover:bg-indigo-50 hover:border-indigo-200 transition-all">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                            {{-- Next --}}
                            @if ($products->hasMorePages())
                                <a href="{{ $products->nextPageUrl() }}"
                                    class="w-9 h-9 flex items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 hover:border-indigo-200 transition-all">
                                    <i data-lucide="chevron-right"
                                        class="w-4 h-4"></i>
                                </a>
                            @else
                                <span
                                    class="w-9 h-9 flex items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-300">
                                    <i data-lucide="chevron-right"
                                        class="w-4 h-4"></i>
                                </span>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-layout>
