<x-layout>
    <div class="lg:ml-72 min-h-screen flex flex-col transition-all duration-300">
        {{-- Topbar --}}
        <x-navigation.topbar />
        {{-- Page Content --}}
        <main class="p-4 lg:p-8 flex-grow">
            {{-- Header --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                <div>
                    <div class="flex items-center gap-2 text-slate-500 text-sm mb-2">
                        <a href="{{ route('products.index') }}" class="hover:text-indigo-600 text-xs font-medium">
                            Produits
                        </a>
                        <i data-lucide="chevron-right" class="w-3 h-3 text-slate-400"></i>
                        <span class="text-slate-900 font-medium text-xs">
                            Catégories
                        </span>
                    </div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Catégories de Produits
                    </h1>
                    <p class="text-slate-500 text-sm">
                        Organisez et segmentez votre inventaire WoStock.
                    </p>
                </div>
                {{-- Add --}}
                <a href="{{ route('categories.create') }}"
                    class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-indigo-700 shadow-lg shadow-indigo-600/20 transition-all flex items-center gap-2">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    Nouvelle Catégorie
                </a>
            </div>
            {{-- Table --}}
            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                {{-- Search --}}
                <div class="p-4 border-b border-slate-100 bg-slate-50/30">
                    <div class="relative w-full md:w-80">
                        <i data-lucide="search"
                            class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                        <input type="text" id="categorySearch" value="{{ request('search') }}"
                            placeholder="Rechercher une catégorie..." autocomplete="off"
                            class="w-full pl-10 pr-10 py-2 rounded-xl border border-slate-200 bg-white text-slate-900 placeholder-slate-400 outline-none focus:border-indigo-500 text-sm">
                        <button type="button" id="clearSearch"
                            class="hidden absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse" id="categoriesTable">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="px-6 py-4 text-xs uppercase font-bold text-slate-500">
                                    Nom
                                </th>
                                <th class="px-6 py-4 text-xs uppercase font-bold text-slate-500">
                                    Description
                                </th>
                                <th class="px-6 py-4 text-xs uppercase font-bold text-slate-500 text-center">
                                    Produits
                                </th>
                                <th class="px-6 py-4 text-xs uppercase font-bold text-slate-500 text-right">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($categories as $category)
                                @php
                                    $name = trim($category->name);
                                    $initials = collect(preg_split('/\s+/', $name))
                                        ->filter()
                                        ->take(2)
                                        ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                                        ->implode('');
                                    if ($initials === '') {
                                        $initials = '?';
                                    }
                                @endphp
                                <tr class="hover:bg-slate-50/80 transition-colors group">
                                    {{-- Name --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center border border-indigo-100 font-bold">
                                                {{ $initials }}
                                            </div>
                                            <span class="text-sm font-bold text-slate-800">
                                                {{ $category->name }}
                                            </span>
                                        </div>
                                    </td>
                                    {{-- Description --}}
                                    <td class="px-6 py-4 text-sm text-slate-500 italic text-wrap max-w-xs">
                                        @if ($category->description)
                                            {{ $category->description }}
                                        @else
                                            <span class="text-slate-400 not-italic">
                                                Aucune description
                                            </span>
                                        @endif
                                    </td>
                                    {{-- Products Count --}}
                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600">
                                            {{ $category->products_count }}
                                        </span>
                                    </td>
                                    {{-- Actions --}}
                                    <td class="px-6 py-4 text-right">
                                        <div
                                            class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            {{-- Edit --}}
                                            <a href="{{ route('categories.edit', $category) }}"
                                                class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all"
                                                title="Modifier">
                                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                                            </a>
                                            {{-- Delete --}}
                                            <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                                onsubmit="return confirm('Voulez-vous vraiment supprimer cette catégorie ?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                                    title="Supprimer">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div
                                                class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center mb-4">
                                                <i data-lucide="folder-open" class="w-7 h-7 text-slate-400"></i>
                                            </div>
                                            <h3 class="font-semibold text-slate-700">
                                                Aucune catégorie trouvée
                                            </h3>
                                            <p class="text-sm text-slate-400 mt-1">
                                                Aucune catégorie ne correspond à votre recherche.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- Pagination --}}
                <div
                    class="p-4 border-t border-slate-100 bg-slate-50/50 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    {{-- Results Count --}}
                    <p data-results-count class="text-sm text-slate-500">
                        Affichage de
                        @if ($categories->total() > 0)
                            <span class="font-bold text-slate-800">
                                {{ $categories->firstItem() }}-{{ $categories->lastItem() }}
                            </span>
                        @else
                            <span class="font-bold text-slate-800">
                                0
                            </span>
                        @endif
                        sur
                        <span class="font-bold text-slate-800">
                            {{ $categories->total() }}
                        </span>
                        catégories
                    </p>
                    {{-- Pagination --}}
                    <div data-pagination class="flex items-center gap-1">
                        @if ($categories->hasPages())
                            {{-- Previous --}}
                            @if ($categories->onFirstPage())
                                <span
                                    class="w-9 h-9 flex items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-300">
                                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                                </span>
                            @else
                                <a href="{{ $categories->previousPageUrl() }}" data-pagination-link
                                    class="w-9 h-9 flex items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 hover:border-indigo-200 transition-all">
                                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                                </a>
                            @endif
                            @php
                                $currentPage = $categories->currentPage();
                                $lastPage = $categories->lastPage();
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
                                    <a href="{{ $categories->url($page) }}" data-pagination-link
                                        class="w-9 h-9 flex items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 text-sm hover:text-indigo-600 hover:bg-indigo-50 hover:border-indigo-200 transition-all">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                            {{-- Next --}}
                            @if ($categories->hasMorePages())
                                <a href="{{ $categories->nextPageUrl() }}" data-pagination-link
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
    <x-ui.success />
    <x-ui.error />
    {{-- Search JS only --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('categorySearch');
            const clearSearch = document.getElementById('clearSearch');
            let searchTimeout = null;

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

            function buildUrl() {
                const url = new URL(
                    '{{ route('categories.index') }}',
                    window.location.origin
                );
                const search = searchInput.value.trim();
                if (search !== '') {
                    url.searchParams.set(
                        'search',
                        search
                    );
                }
                url.searchParams.delete('page');
                return url.toString();
            }

            function loadCategories(url, keepFocus = false) {
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
                                'HTTP error ' + response.status
                            );
                        }
                        return response.text();
                    })
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(
                            html,
                            'text/html'
                        );
                        const newTableBody = doc.querySelector(
                            '#categoriesTable tbody'
                        );
                        const currentTableBody = document.querySelector(
                            '#categoriesTable tbody'
                        );
                        if (newTableBody && currentTableBody) {
                            currentTableBody.innerHTML =
                                newTableBody.innerHTML;
                        }
                        const newResults = doc.querySelector(
                            '[data-results-count]'
                        );
                        const currentResults = document.querySelector(
                            '[data-results-count]'
                        );
                        if (newResults && currentResults) {
                            currentResults.innerHTML =
                                newResults.innerHTML;
                        }
                        const newPagination = doc.querySelector(
                            '[data-pagination]'
                        );
                        const currentPagination = document.querySelector(
                            '[data-pagination]'
                        );
                        if (newPagination && currentPagination) {
                            currentPagination.replaceWith(
                                newPagination
                            );
                        }
                        if (!newPagination && currentPagination) {
                            currentPagination.innerHTML = '';
                        }
                        window.history.replaceState({},
                            '',
                            url
                        );
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
                            'Categories AJAX error:',
                            error
                        );
                    });
            }
            searchInput.addEventListener(
                'input',
                function() {
                    clearTimeout(searchTimeout);
                    updateClearButton();
                    searchTimeout = setTimeout(
                        function() {
                            loadCategories(
                                buildUrl(),
                                true
                            );
                        },
                        400
                    );
                }
            );
            document.addEventListener(
                'click',
                function(event) {
                    const link = event.target.closest(
                        '[data-pagination-link]'
                    );
                    if (!link) {
                        return;
                    }
                    event.preventDefault();
                    loadCategories(
                        link.href,
                        false
                    );
                }
            );
            clearSearch.addEventListener(
                'click',
                function() {
                    clearTimeout(searchTimeout);
                    searchInput.value = '';
                    updateClearButton();
                    loadCategories(
                        buildUrl(),
                        true
                    );
                }
            );
            updateClearButton();
            refreshIcons();
        });
    </script>
</x-layout>
