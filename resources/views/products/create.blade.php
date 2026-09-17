<x-layout>
    <div
        class="lg:ml-72 min-h-screen flex flex-col transition-all duration-300"
        x-data="{ submitting: false }"
    >
        <x-navigation.topbar />

        <main class="p-4 lg:p-8 flex-grow">

            <!-- En-tête -->
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                <div>
                    <div class="flex items-center gap-2 text-slate-500 text-sm mb-2">
                        <a
                            href="{{ route('products.index') }}"
                            class="hover:text-indigo-600 text-xs font-medium"
                        >
                            Produits
                        </a>

                        <i
                            data-lucide="chevron-right"
                            class="w-3 h-3 text-slate-400"
                        ></i>

                        <span class="text-slate-900 font-medium text-xs">
                            Nouveau produit
                        </span>
                    </div>

                    <h1 class="text-2xl font-bold text-slate-900">
                        Créer un nouveau produit
                    </h1>

                    <p class="text-slate-500 text-sm">
                        Remplissez les informations pour ajouter un article à l'inventaire.
                    </p>
                </div>

                <div class="flex items-center gap-3">

                    <a
                        href="{{ route('products.index') }}"
                        class="px-6 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-semibold text-sm hover:bg-slate-50"
                    >
                        Annuler
                    </a>

                    <button
                        type="submit"
                        form="product-form"
                        x-bind:disabled="submitting"
                        class="px-6 py-2.5 rounded-xl bg-indigo-600 text-white font-semibold text-sm hover:bg-indigo-700 shadow-lg shadow-indigo-600/20 flex items-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed"
                    >
                        <template x-if="!submitting">
                            <span class="flex items-center gap-2">
                                <i
                                    data-lucide="plus-circle"
                                    class="w-4 h-4"
                                ></i>

                                Enregistrer le produit
                            </span>
                        </template>

                        <template x-if="submitting">
                            <span class="flex items-center gap-2">
                                <i
                                    data-lucide="loader-circle"
                                    class="w-4 h-4 animate-spin"
                                ></i>

                                Traitement...
                            </span>
                        </template>
                    </button>
                </div>
            </div>

            <!-- Formulaire -->
            <form
                id="product-form"
                action="{{ route('products.store') }}"
                method="POST"
                enctype="multipart/form-data"
                @submit="submitting = true"
            >
                @csrf

                <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

                    <!-- Colonne gauche -->
                    <div class="xl:col-span-2 space-y-6">

                        <!-- Informations de base -->
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">

                            <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                                <i
                                    data-lucide="package"
                                    class="w-5 h-5 text-indigo-500"
                                ></i>

                                Détails de l'article
                            </h3>

                            <div class="space-y-4">

                                <!-- Nom -->
                                <div>
                                    <label
                                        for="name"
                                        class="block text-sm font-semibold text-slate-700 mb-2"
                                    >
                                        Nom du produit *
                                    </label>

                                    <input
                                        type="text"
                                        id="name"
                                        name="name"
                                        value="{{ old('name') }}"
                                        placeholder="Ex: Casque Bluetooth Bose QC45"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-900 placeholder-slate-400 outline-none focus:border-indigo-500"
                                        
                                    >

                                    @error('name')
                                        <p class="mt-2 text-sm text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                    <!-- SKU -->
                                    <div>
                                        <label
                                            for="sku"
                                            class="block text-sm font-semibold text-slate-700 mb-2"
                                        >
                                            Référence / SKU *
                                        </label>

                                        <input
                                            type="text"
                                            id="sku"
                                            name="sku"
                                            value="{{ old('sku') }}"
                                            placeholder="Ex: WST-2024-001"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-900 placeholder-slate-400 outline-none focus:border-indigo-500"
                                            
                                        >

                                        @error('sku')
                                            <p class="mt-2 text-sm text-red-600">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <!-- Catégorie -->
                                    <div>
                                        <label
                                            for="category_id"
                                            class="block text-sm font-semibold text-slate-700 mb-2"
                                        >
                                            Catégorie
                                        </label>

                                        <select
                                            id="category_id"
                                            name="category_id"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-900 outline-none focus:border-indigo-500"
                                        >
                                            <option value="">
                                                Choisir une catégorie
                                            </option>

                                            @foreach ($categories as $category)
                                                <option
                                                    value="{{ $category->id }}"
                                                    @selected(old('category_id') == $category->id)
                                                >
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('category_id')
                                            <p class="mt-2 text-sm text-red-600">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Prix & Stock -->
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">

                            <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                                <i
                                    data-lucide="banknote"
                                    class="w-5 h-5 text-indigo-500"
                                ></i>

                                Prix & Gestion de stock
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                                <!-- Prix -->
                                <div>
                                    <label
                                        for="price"
                                        class="block text-sm font-semibold text-slate-700 mb-2"
                                    >
                                        Prix unitaire (DH) *
                                    </label>

                                    <input
                                        type="number"
                                        id="price"
                                        name="price"
                                        value="{{ old('price') }}"
                                        placeholder="0.00"
                                        min="0"
                                        step="0.01"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-900 placeholder-slate-400 outline-none focus:border-indigo-500 font-bold text-indigo-600"
                                        
                                    >

                                    @error('price')
                                        <p class="mt-2 text-sm text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Stock -->
                                <div>
                                    <label
                                        for="stock_quantity"
                                        class="block text-sm font-semibold text-slate-700 mb-2"
                                    >
                                        Quantité initiale *
                                    </label>

                                    <input
                                        type="number"
                                        id="stock_quantity"
                                        name="stock_quantity"
                                        value="{{ old('stock_quantity', 0) }}"
                                        placeholder="0"
                                        min="0"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-900 placeholder-slate-400 outline-none focus:border-indigo-500 font-bold"
                                        
                                    >

                                    @error('stock_quantity')
                                        <p class="mt-2 text-sm text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Minimum stock -->
                                <div>
                                    <label
                                        for="minimum_stock"
                                        class="block text-sm font-semibold text-slate-700 mb-2"
                                    >
                                        Alerte stock minimum
                                    </label>

                                    <input
                                        type="number"
                                        id="minimum_stock"
                                        name="minimum_stock"
                                        value="{{ old('minimum_stock', 0) }}"
                                        placeholder="5"
                                        min="0"
                                        class="w-full px-4 py-3 rounded-xl border border-orange-200 bg-white text-slate-900 placeholder-slate-400 outline-none focus:border-orange-500 font-bold text-orange-600"
                                    >

                                    @error('minimum_stock')
                                        <p class="mt-2 text-sm text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                            </div>
                        </div>

                    </div>

                    <!-- Colonne droite -->
                    <div class="space-y-6">

                        <!-- Image -->
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">

                            <h3 class="text-sm font-bold text-slate-800 mb-4">
                                Image du produit
                            </h3>

                            <div
                                id="image-container"
                                class="relative group mx-auto w-full aspect-square bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200 flex flex-col items-center justify-center overflow-hidden hover:border-indigo-400"
                            >

                                <img
                                    id="preview"
                                    src=""
                                    class="hidden object-cover w-full h-full"
                                >

                                <div
                                    id="upload-placeholder"
                                    class="text-center p-4"
                                >
                                    <i
                                        data-lucide="image-plus"
                                        class="w-10 h-10 text-slate-300 mx-auto mb-2"
                                    ></i>

                                    <p class="text-[10px] text-slate-500 font-medium">
                                        Cliquez ou glissez une image ici
                                    </p>
                                </div>

                                <input
                                    type="file"
                                    id="image"
                                    name="image"
                                    class="absolute inset-0 opacity-0 cursor-pointer"
                                    accept="image/*"
                                    onchange="previewImage(this)"
                                >

                            </div>

                            @error('image')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        <!-- Fournisseur -->
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">

                            <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                                <i
                                    data-lucide="truck"
                                    class="w-4 h-4"
                                ></i>

                                Fournisseur *
                            </h3>

                            <select
                                id="supplier_id"
                                name="supplier_id"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-900 outline-none focus:border-indigo-500"
                                
                            >
                                <option value="">
                                    Sélectionner fournisseur
                                </option>

                                @foreach ($suppliers as $supplier)
                                    <option
                                        value="{{ $supplier->id }}"
                                        @selected(old('supplier_id') == $supplier->id)
                                    >
                                        {{ $supplier->company_name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('supplier_id')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>

                </div>
            </form>
        </main>
    </div>

    <!-- Loading overlay -->
    <div
        x-show="submitting"
        x-cloak
        class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/40 backdrop-blur-sm"
    >
        <div class="bg-white rounded-2xl px-8 py-7 shadow-2xl text-center">

            <div class="flex justify-center">
                <i
                    data-lucide="loader-circle"
                    class="w-9 h-9 text-indigo-600 animate-spin"
                ></i>
            </div>

            <p class="mt-4 text-sm font-semibold text-slate-800">
                Traitement du produit...
            </p>

            <p class="mt-1 text-xs text-slate-500">
                L'image est en cours de compression.
            </p>

        </div>
    </div>

    <x-ui.success />
    <x-ui.error />

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('preview');
            const placeholder = document.getElementById('upload-placeholder');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');

                    if (placeholder) {
                        placeholder.classList.add('hidden');
                    }
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        lucide.createIcons();
    </script>
</x-layout>