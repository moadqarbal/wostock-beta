<x-layout>
    <div class="lg:ml-72 min-h-screen flex flex-col transition-all duration-300">
        <x-navigation.topbar />
        <!-- PAGE CONTENT -->
        <main class="p-4 lg:p-8 flex-grow w-full">
            <!-- En-tête -->
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                <div class="flex items-center gap-4">
                    <a href="{{ route('products.index') }}"
                        class="p-2.5 bg-white border border-slate-200 rounded-xl text-slate-400 hover:text-indigo-600 shadow-sm">
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    </a>
                    <div>
                        <div
                            class="flex items-center gap-2 text-slate-500 text-[10px] uppercase font-bold tracking-widest mb-1">
                            <span>Produits</span>
                            <i data-lucide="chevron-right" class="w-3 h-3"></i>
                            <span class="text-slate-900">
                                Détails Produit
                            </span>
                        </div>
                        <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">
                            {{ $product->name }}
                        </h1>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <form action="{{ route('products.destroy', $product) }}" method="POST" id="delete-product-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="deleteProduct()"
                            class="p-2.5 bg-white border border-red-100 rounded-xl text-red-500 hover:bg-red-50"
                            title="Supprimer">
                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                        </button>
                    </form>
                    <a href="{{ route('products.edit', $product) }}"
                        class="px-5 py-2.5 bg-white border border-slate-200 rounded-xl text-slate-600 text-xs font-black uppercase tracking-widest hover:bg-slate-50 flex items-center gap-2">
                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                        Modifier
                    </a>
                </div>
            </div>
            <!-- Bento Grid Stats -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
                <!-- Image Produit -->
                <div
                    class="bg-white p-2 rounded-3xl border border-slate-100 shadow-sm flex items-center justify-center overflow-hidden">
                    @if ($product->image)
                        <a href="{{ asset('uploads/' . $product->image) }}" class="glightbox" data-gallery="product"
                            data-glightbox="title: {{ $product->name }}" onclick="event.preventDefault();">
                            <img src="{{ asset('uploads/' . $product->image) }}" alt="{{ $product->name }}"
                                class="w-full h-48 object-contain hover:scale-105 transition-transform duration-500 cursor-zoom-in">
                        </a>
                    @else
                        <div class="w-full h-48 flex items-center justify-center text-slate-300">
                            <i data-lucide="image" class="w-16 h-16"></i>
                        </div>
                    @endif
                </div>
                <!-- Stats -->
                <div class="lg:col-span-3 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Revenus -->
                    <div
                        class="bg-indigo-600 p-8 rounded-3xl shadow-lg shadow-indigo-200 text-white flex flex-col justify-between md:row-span-2 relative overflow-hidden group">
                        <i data-lucide="trending-up"
                            class="w-24 h-24 absolute -right-6 -bottom-6 opacity-20 group-hover:scale-110 transition-all"></i>
                        <div>
                            <p class="text-indigo-100 text-[10px] font-black uppercase tracking-[0.2em] mb-1">
                                Revenus Générés
                            </p>
                            <h3 class="text-4xl font-black tracking-tighter">
                                {{ number_format($totalRevenue, 2, ',', ' ') }}
                                <span class="text-sm font-normal opacity-70">
                                    DH
                                </span>
                            </h3>
                        </div>
                        <div class="mt-8">
                            <span
                                class="bg-white/20 px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider">
                                Ventes du produit
                            </span>
                        </div>
                    </div>
                    <!-- Total Vendu -->
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center gap-5">
                        <div class="p-4 bg-emerald-50 text-emerald-600 rounded-2xl">
                            <i data-lucide="shopping-cart" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-1">
                                Total Vendu
                            </p>
                            <h3 class="text-2xl font-black text-slate-800 tracking-tight">
                                {{ $totalSold }}
                                <span class="text-xs font-bold">
                                    Unités
                                </span>
                            </h3>
                        </div>
                    </div>
                    <!-- Stock -->
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center gap-5">
                        <div class="p-4 bg-orange-50 text-orange-600 rounded-2xl">
                            <i data-lucide="package" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-1">
                                Stock Restant
                            </p>
                            <h3 class="text-2xl font-black text-slate-800 tracking-tight">
                                {{ $product->stock_quantity }}
                                <span class="text-xs text-orange-400 font-bold">
                                    (Min {{ $product->minimum_stock }})
                                </span>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Informations -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <!-- Fiche Technique -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
                        <h3
                            class="text-sm font-black text-slate-800 uppercase tracking-widest mb-6 border-b border-slate-50 pb-4">
                            Fiche Technique
                        </h3>
                        <div class="grid grid-cols-2 gap-y-6 gap-x-8">
                            <!-- SKU -->
                            <div>
                                <p class="text-[10px] text-slate-400 font-bold uppercase mb-1">
                                    Référence SKU
                                </p>
                                <p class="text-sm font-black text-slate-800 italic">
                                    {{ $product->sku }}
                                </p>
                            </div>
                            <!-- Catégorie -->
                            <div>
                                <p class="text-[10px] text-slate-400 font-bold uppercase mb-1">
                                    Catégorie
                                </p>
                                <p class="text-sm font-black text-indigo-600">
                                    {{ $product->category?->name ?? 'Sans catégorie' }}
                                </p>
                            </div>
                            <!-- Prix -->
                            <div>
                                <p class="text-[10px] text-slate-400 font-bold uppercase mb-1">
                                    Prix de vente
                                </p>
                                <p class="text-sm font-black text-slate-800 font-mono">
                                    {{ number_format($product->price, 2, ',', ' ') }}
                                    DH
                                </p>
                            </div>
                            <!-- Date -->
                            <div>
                                <p class="text-[10px] text-slate-400 font-bold uppercase mb-1">
                                    Date d'ajout
                                </p>
                                <p class="text-sm font-black text-slate-800">
                                    {{ $product->created_at->translatedFormat('d F Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fournisseur -->
                <div
                    class="bg-slate-900 p-8 rounded-3xl shadow-xl shadow-slate-200 text-white relative overflow-hidden">
                    <i data-lucide="truck" class="w-20 h-20 absolute -right-4 -bottom-4 opacity-5"></i>
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">
                        Fournisseur
                    </h3>
                    <div class="flex items-center gap-4 mb-6">
                        <div
                            class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center font-black text-indigo-400 border border-white/10">
                            {{ strtoupper(substr($product->supplier?->company_name ?? '?', 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="font-black text-sm uppercase">
                                {{ $product->supplier?->company_name ?? 'Non défini' }}
                            </h4>
                            <p class="text-[10px] text-slate-400">
                                ID #{{ $product->supplier?->id ?? '-' }}
                            </p>
                        </div>
                    </div>
                    <div class="space-y-3">
                        @if ($product->supplier?->phone)
                            <div class="flex items-center gap-3 text-xs font-bold text-slate-300">
                                <i data-lucide="phone" class="w-4 h-4 text-indigo-400"></i>
                                {{ $product->supplier->phone }}
                            </div>
                        @endif
                        @if ($product->supplier?->email)
                            <div class="flex items-center gap-3 text-xs font-bold text-slate-300">
                                <i data-lucide="mail" class="w-4 h-4 text-indigo-400"></i>
                                {{ $product->supplier->email }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Historique des ventes -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div
                    class="p-6 border-b border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4 bg-slate-50/30">
                    <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">
                        Historique des ventes de cet article
                    </h3>
                    <div class="relative w-full md:w-64">
                        <i data-lucide="search"
                            class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                        <input type="text" id="salesSearch" onkeyup="filterSales()"
                            placeholder="Rechercher une vente..."
                            class="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-200 text-xs outline-none bg-white">
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse" id="salesTable">
                        <thead>
                            <tr
                                class="bg-slate-50/50 text-slate-400 text-[10px] uppercase font-black tracking-widest border-b border-slate-100">
                                <th class="px-6 py-4">
                                    Client
                                </th>
                                <th class="px-6 py-4">
                                    N° Commande
                                </th>
                                <th class="px-6 py-4">
                                    Date
                                </th>
                                <th class="px-6 py-4">
                                    Quantité
                                </th>
                                <th class="px-6 py-4 text-right">
                                    Montant
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse ($product->orderItems as $item)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <!-- Client -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            @php
                                                $clientName = $item->order?->client?->name ?? 'Client inconnu';
                                                $initials = collect(preg_split('/\s+/', trim($clientName)))
                                                    ->filter()
                                                    ->take(2)
                                                    ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                                                    ->implode('');
                                            @endphp
                                            <div
                                                class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-[10px] font-black">
                                                {{ $initials ?: '?' }}
                                            </div>
                                            <span class="text-xs font-bold text-slate-800">
                                                {{ $clientName }}
                                            </span>
                                        </div>
                                    </td>
                                    <!-- Commande -->
                                    <td class="px-6 py-4 font-black text-slate-700 text-xs">
                                        #{{ $item->order?->id }}
                                    </td>
                                    <!-- Date -->
                                    <td class="px-6 py-4 text-slate-500 text-[11px] font-bold">
                                        {{ $item->order?->created_at?->format('d/m/Y') }}
                                    </td>
                                    <!-- Quantité -->
                                    <td class="px-6 py-4 text-slate-700 text-xs font-black italic">
                                        x{{ $item->quantity }} Unité
                                    </td>
                                    <!-- Montant -->
                                    <td class="px-6 py-4 font-black text-slate-900 text-sm text-right">
                                        {{ number_format($item->subtotal, 2, ',', ' ') }}
                                        DH
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <i data-lucide="shopping-cart" class="w-10 h-10 text-slate-300 mb-3"></i>
                                            <p class="text-sm font-bold text-slate-500">
                                                Aucune vente pour ce produit.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    <x-ui.success />
    <x-ui.error />
    <script>
        lucide.createIcons();
        // Recherche dans l'historique
        function filterSales() {
            const input = document.getElementById("salesSearch");
            const filter = input.value.toLowerCase();
            const table = document.getElementById("salesTable");
            const tr = table.getElementsByTagName("tr");
            for (let i = 1; i < tr.length; i++) {
                const textContent = tr[i].textContent.toLowerCase();
                tr[i].style.display =
                    textContent.includes(filter) ? "" : "none";
            }
        }
        // Suppression
        function deleteProduct() {
            Swal.fire({
                title: 'Supprimer ce produit ?',
                text: "Cette action est irréversible et affectera vos statistiques.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#f1f5f9',
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-3xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document
                        .getElementById('delete-product-form')
                        .submit();
                }
            });
        }
    </script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

    <script>
    const lightbox = GLightbox({
        selector: '.glightbox',
        touchNavigation: true,
        loop: true,
        zoomable: true
    });

    document.querySelectorAll('.glightbox').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
        });
    });
</script>
</x-layout>
