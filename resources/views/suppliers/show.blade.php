<x-layout>
    <div class="lg:ml-72 min-h-screen flex flex-col">
        <x-navigation.topbar />
        <main class="p-4 lg:p-8 flex-grow w-full">
            <!-- Header -->
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-8">
                <div>
                    <div class="flex items-center gap-2 text-slate-500 text-sm mb-3">
                        <a
                            href="{{ route('suppliers.index') }}"
                            class="text-xs font-medium hover:text-indigo-600 transition-colors"
                        >
                            Fournisseurs
                        </a>
                        <i
                            data-lucide="chevron-right"
                            class="w-3 h-3 text-slate-400"
                        ></i>
                        <span class="text-slate-900 text-xs font-medium">
                            {{ $supplier->company_name }}
                        </span>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center">
                            <span class="text-xl font-bold text-indigo-600">
                                {{ strtoupper(substr($supplier->company_name, 0, 1)) }}
                            </span>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-slate-900">
                                {{ $supplier->company_name }}
                            </h1>
                            <p class="text-sm text-slate-500 mt-1">
                                Fiche fournisseur
                            </p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <a
                        href="{{ route('suppliers.index') }}"
                        class="px-5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-600 font-semibold text-sm hover:bg-slate-50 transition"
                    >
                        Retour
                    </a>
                    <a
                        href="{{-- route('suppliers.edit', $supplier) --}}"
                        class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white font-semibold text-sm hover:bg-indigo-700 transition flex items-center gap-2 shadow-lg shadow-indigo-600/20"
                    >
                        <i data-lucide="pencil" class="w-4 h-4"></i>
                        Modifier
                    </a>
                </div>
            </div>
            <!-- Overview cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">
                <!-- Produits -->
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center">
                            <i data-lucide="package" class="w-5 h-5 text-indigo-600"></i>
                        </div>
                    </div>
                    <p class="text-sm text-slate-500">
                        Produits
                    </p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">
                        {{ $supplier->products->count() }}
                    </p>
                </div>
                <!-- Valeur stock -->
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center">
                            <i data-lucide="wallet" class="w-5 h-5 text-emerald-600"></i>
                        </div>
                    </div>
                    <p class="text-sm text-slate-500">
                        Valeur du stock
                    </p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">
                        {{ number_format($supplier->products->sum(fn ($product) => $product->price * $product->stock_quantity), 2, '.', ',') }}
                        <span class="text-sm font-medium text-slate-400">DH</span>
                    </p>
                </div>
                <!-- Ville -->
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
                            <i data-lucide="map-pin" class="w-5 h-5 text-amber-600"></i>
                        </div>
                    </div>
                    <p class="text-sm text-slate-500">
                        Localisation
                    </p>
                    <p class="text-lg font-bold text-slate-900 mt-1">
                        {{ $supplier->city ?? 'Non renseignée' }}
                    </p>
                </div>
                <!-- Date -->
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 rounded-xl bg-violet-50 flex items-center justify-center">
                            <i data-lucide="calendar-days" class="w-5 h-5 text-violet-600"></i>
                        </div>
                    </div>
                    <p class="text-sm text-slate-500">
                        Fournisseur depuis
                    </p>
                    <p class="text-lg font-bold text-slate-900 mt-1">
                        {{ $supplier->created_at->format('d/m/Y') }}
                    </p>
                </div>
            </div>
            <!-- Main content -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                <!-- Left -->
                <div class="xl:col-span-2 space-y-8">
                    <!-- Informations -->
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm">
                        <div class="p-6 border-b border-slate-100">
                            <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                                <i
                                    data-lucide="building-2"
                                    class="w-5 h-5 text-indigo-500"
                                ></i>
                                Informations du fournisseur
                            </h2>
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Company -->
                            <div>
                                <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">
                                    Entreprise
                                </p>
                                <p class="text-sm font-semibold text-slate-800 mt-2">
                                    {{ $supplier->company_name }}
                                </p>
                            </div>
                            <!-- Phone -->
                            <div>
                                <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">
                                    Téléphone
                                </p>
                                @if ($supplier->phone)
                                    <a
                                        href="tel:{{ $supplier->phone }}"
                                        class="text-sm font-semibold text-indigo-600 hover:text-indigo-700 mt-2 inline-block"
                                    >
                                        {{ $supplier->phone }}
                                    </a>
                                @else
                                    <p class="text-sm text-slate-400 mt-2">
                                        Non renseigné
                                    </p>
                                @endif
                            </div>
                            <!-- Email -->
                            <div>
                                <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">
                                    E-mail
                                </p>
                                @if ($supplier->email)
                                    <a
                                        href="mailto:{{ $supplier->email }}"
                                        class="text-sm font-semibold text-indigo-600 hover:text-indigo-700 mt-2 inline-block break-all"
                                    >
                                        {{ $supplier->email }}
                                    </a>
                                @else
                                    <p class="text-sm text-slate-400 mt-2">
                                        Non renseigné
                                    </p>
                                @endif
                            </div>
                            <!-- Country -->
                            <div>
                                <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">
                                    Pays
                                </p>
                                <p class="text-sm font-semibold text-slate-800 mt-2">
                                    {{ $supplier->country }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- Adresse -->
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm">
                        <div class="p-6 border-b border-slate-100">
                            <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                                <i
                                    data-lucide="map-pin"
                                    class="w-5 h-5 text-indigo-500"
                                ></i>
                                Adresse & Localisation
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="md:col-span-3">
                                    <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">
                                        Adresse
                                    </p>
                                    <p class="text-sm font-medium text-slate-800 mt-2">
                                        {{ $supplier->address ?? 'Non renseignée' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">
                                        Ville
                                    </p>
                                    <p class="text-sm font-semibold text-slate-800 mt-2">
                                        {{ $supplier->city ?? 'Non renseignée' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">
                                        Code Postal
                                    </p>
                                    <p class="text-sm font-semibold text-slate-800 mt-2">
                                        {{ $supplier->postal_code ?? 'Non renseigné' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">
                                        Pays
                                    </p>
                                    <p class="text-sm font-semibold text-slate-800 mt-2">
                                        {{ $supplier->country }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Produits -->
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                            <div>
                                <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                                    <i
                                        data-lucide="package"
                                        class="w-5 h-5 text-indigo-500"
                                    ></i>
                                    Produits du fournisseur
                                </h2>
                                <p class="text-sm text-slate-500 mt-1">
                                    Produits associés à ce fournisseur.
                                </p>
                            </div>
                            <span class="px-3 py-1.5 rounded-lg bg-indigo-50 text-indigo-600 text-xs font-bold">
                                {{ $supplier->products->count() }} produits
                            </span>
                        </div>
                        @if ($supplier->products->count())
                            <div class="overflow-x-auto">
                                <table class="w-full text-left">
                                    <thead class="bg-slate-50 border-b border-slate-100">
                                        <tr>
                                            <th class="px-6 py-4 text-xs font-semibold text-slate-500">
                                                Produit
                                            </th>
                                            <th class="px-6 py-4 text-xs font-semibold text-slate-500">
                                                SKU
                                            </th>
                                            <th class="px-6 py-4 text-xs font-semibold text-slate-500">
                                                Prix
                                            </th>
                                            <th class="px-6 py-4 text-xs font-semibold text-slate-500">
                                                Stock
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        @foreach ($supplier->products as $product)
                                            <tr class="hover:bg-slate-50">
                                                <td class="px-6 py-4">
                                                    <div class="flex items-center gap-3">
                                                        <div class="w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center">
                                                            <i
                                                                data-lucide="package"
                                                                class="w-4 h-4 text-slate-500"
                                                            ></i>
                                                        </div>
                                                        <span class="text-sm font-semibold text-slate-800">
                                                            {{ $product->name }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 text-sm text-slate-500">
                                                    {{ $product->sku }}
                                                </td>
                                                <td class="px-6 py-4 text-sm font-semibold text-slate-800">
                                                    {{ number_format($product->price, 2, '.', ',') }} DH
                                                </td>
                                                <td class="px-6 py-4">
                                                    <span class="text-sm font-semibold text-slate-800">
                                                        {{ $product->stock_quantity }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="px-6 py-14 text-center">
                                <div class="w-14 h-14 mx-auto rounded-2xl bg-slate-100 flex items-center justify-center">
                                    <i
                                        data-lucide="package-open"
                                        class="w-7 h-7 text-slate-400"
                                    ></i>
                                </div>
                                <h3 class="mt-4 text-sm font-bold text-slate-800">
                                    Aucun produit
                                </h3>
                                <p class="mt-1 text-sm text-slate-500">
                                    Aucun produit n'est actuellement associé à ce fournisseur.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
                <!-- Right -->
                <div class="space-y-8">
                    <!-- Contact card -->
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                        <h2 class="text-sm font-bold text-slate-900 mb-5">
                            Contact
                        </h2>
                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center shrink-0">
                                    <i
                                        data-lucide="phone"
                                        class="w-4 h-4 text-indigo-600"
                                    ></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs text-slate-400">
                                        Téléphone
                                    </p>
                                    <p class="text-sm font-semibold text-slate-800 truncate">
                                        {{ $supplier->phone }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center shrink-0">
                                    <i
                                        data-lucide="mail"
                                        class="w-4 h-4 text-indigo-600"
                                    ></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs text-slate-400">
                                        E-mail
                                    </p>
                                    <p class="text-sm font-semibold text-slate-800 truncate">
                                        {{ $supplier->email ?? 'Non renseigné' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Notes -->
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                        <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2 mb-4">
                            <i
                                data-lucide="sticky-note"
                                class="w-4 h-4 text-indigo-500"
                            ></i>
                            Notes confidentielles
                        </h2>
                        @if ($supplier->notes)
                            <div class="bg-amber-50 border border-amber-100 rounded-xl p-4">
                                <p class="text-sm text-amber-800 leading-relaxed whitespace-pre-line">
                                    {{ $supplier->notes }}
                                </p>
                            </div>
                        @else
                            <div class="text-center py-6">
                                <i
                                    data-lucide="notebook-pen"
                                    class="w-6 h-6 text-slate-300 mx-auto"
                                ></i>
                                <p class="text-sm text-slate-400 mt-2">
                                    Aucune note ajoutée.
                                </p>
                            </div>
                        @endif
                        <p class="text-[11px] text-slate-400 mt-4 leading-relaxed">
                            Ces informations sont uniquement visibles dans votre espace de gestion.
                        </p>
                    </div>
                    <!-- Metadata -->
                    <div class="bg-slate-900 rounded-2xl p-6 text-white">
                        <h2 class="text-sm font-bold mb-5">
                            Informations système
                        </h2>
                        <div class="space-y-4">
                            <div class="flex justify-between gap-4">
                                <span class="text-xs text-slate-400">
                                    ID fournisseur
                                </span>
                                <span class="text-sm font-semibold">
                                    #{{ $supplier->id }}
                                </span>
                            </div>
                            <div class="flex justify-between gap-4">
                                <span class="text-xs text-slate-400">
                                    Créé le
                                </span>
                                <span class="text-sm font-semibold">
                                    {{ $supplier->created_at->format('d/m/Y') }}
                                </span>
                            </div>
                            <div class="flex justify-between gap-4">
                                <span class="text-xs text-slate-400">
                                    Dernière modification
                                </span>
                                <span class="text-sm font-semibold">
                                    {{ $supplier->updated_at->format('d/m/Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <x-ui.success />
        <x-ui.error />
    </div>
</x-layout>
<script>
    lucide.createIcons();
</script>