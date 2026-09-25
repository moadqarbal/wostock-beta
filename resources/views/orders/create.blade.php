<x-layout>

    <div class="lg:ml-72 min-h-screen flex flex-col transition-all duration-300">

        <x-navigation.topbar />

        <!-- PAGE CONTENT -->
        <main class="p-4 lg:p-8 flex-grow w-full">

            <!-- En-tête -->
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">

                <div>
                    <div class="flex items-center gap-2 text-slate-500 text-sm mb-2">
                        <a href="{{ route('orders.index') }}"
                            class="hover:text-indigo-600 transition-colors text-xs font-medium uppercase tracking-widest">
                            Commandes
                        </a>

                        <i data-lucide="chevron-right" class="w-3 h-3 text-slate-400"></i>

                        <span class="text-slate-900 font-bold text-xs uppercase tracking-widest">
                            Nouvelle Commande
                        </span>
                    </div>

                    <h1 class="text-2xl font-black text-slate-900 tracking-tight">
                        CRÉER UNE COMMANDE
                    </h1>
                </div>

                <div class="flex items-center gap-3">

                    <a href="{{ route('orders.index') }}"
                        class="px-6 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-xs uppercase tracking-widest hover:bg-slate-50 transition-all">
                        Annuler
                    </a>

                    <button type="submit" form="order-form"
                        class="px-6 py-2.5 rounded-xl bg-indigo-600 text-white font-bold text-xs uppercase tracking-widest hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all flex items-center gap-2">
                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                        Enregistrer
                    </button>

                </div>
            </div>

            <!-- FORM -->
            <form id="order-form" action="{{ route('orders.store') }}" method="POST">

                @csrf

                <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

                    <!-- COLONNE GAUCHE -->
                    <div class="xl:col-span-2 space-y-6">

                        <!-- Section Client -->
                        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">

                            <h3
                                class="text-sm font-black text-slate-800 uppercase tracking-widest mb-6 flex items-center gap-2">
                                <i data-lucide="user" class="w-5 h-5 text-indigo-500"></i>
                                Informations Client
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                <div>

                                    <label
                                        class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">
                                        Sélectionner un client *
                                    </label>

                                    <select id="order-client" name="client_id" class="order-select w-full">

                                        <option value="">-- Choisir un client --</option>

                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}"
                                                {{ old('client_id') == $client->id ? 'selected' : '' }}>

                                                {{ $client->name }}

                                                @if ($client->phone)
                                                    — {{ $client->phone }}
                                                @endif

                                            </option>
                                        @endforeach

                                    </select>

                                    @error('client_id')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror

                                </div>

                                <div>

                                    <label
                                        class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">
                                        N° Commande (Auto)
                                    </label>

                                    <input type="text" value="Généré automatiquement" disabled
                                        class="w-full px-4 py-3 rounded-xl border border-slate-100 bg-slate-50 text-slate-400 font-black italic">

                                </div>

                            </div>
                        </div>


                        <!-- Section Produits -->
                        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">

                            <div class="flex justify-between items-center mb-6">

                                <h3
                                    class="text-sm font-black text-slate-800 uppercase tracking-widest flex items-center gap-2">
                                    <i data-lucide="package" class="w-5 h-5 text-indigo-500"></i>
                                    Sélection des articles
                                </h3>

                                <button type="button" onclick="addProductRow()"
                                    class="text-[10px] font-black text-indigo-600 uppercase tracking-widest hover:underline">
                                    + Ajouter un article
                                </button>

                            </div>

                            <div class="overflow-x-auto">

                                <table class="w-full text-left" id="products-table">

                                    <thead>
                                        <tr
                                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">

                                            <th class="pb-4 px-2">
                                                Produit
                                            </th>

                                            <th class="pb-4 px-2 w-32">
                                                Prix (DH)
                                            </th>

                                            <th class="pb-4 px-2 w-24">
                                                Qté
                                            </th>

                                            <th class="pb-4 px-2 w-32">
                                                Total
                                            </th>

                                            <th class="pb-4 px-2 w-10"></th>

                                        </tr>
                                    </thead>

                                    <tbody class="divide-y divide-slate-50">

                                        <tr class="product-row">

                                            <!-- Produit -->
                                            <td class="py-4 px-2">

                                                <select name="products[0][product_id]" class="product-select w-full">

                                                    <option value="">-- Choisir un produit --</option>

                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}"
                                                            data-price="{{ $product->price }}">

                                                            {{ $product->name }}

                                                            @if ($product->sku)
                                                                — {{ $product->sku }}
                                                            @endif

                                                        </option>
                                                    @endforeach

                                                </select>

                                            </td>


                                            <!-- Prix -->
                                            <td class="py-4 px-2">

                                                <input type="number" readonly
                                                    class="price-input w-full bg-transparent text-sm font-bold text-slate-600 outline-none"
                                                    value="0.00">

                                            </td>


                                            <!-- Quantité -->
                                            <td class="py-4 px-2">

                                                <input type="number" name="products[0][quantity]" value="1"
                                                    min="1" oninput="calculateRowTotal(this)"
                                                    class="qty-input w-full px-3 py-2 rounded-lg border border-slate-200 text-sm outline-none focus:ring-1 focus:ring-indigo-500 font-bold">

                                            </td>


                                            <!-- Total -->
                                            <td class="py-4 px-2">

                                                <span class="row-total text-sm font-black text-slate-900">
                                                    0.00
                                                </span>

                                            </td>


                                            <!-- Delete -->
                                            <td class="py-4 px-2">

                                                <button type="button" onclick="removeRow(this)"
                                                    class="text-slate-300 hover:text-red-500">

                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>

                                                </button>

                                            </td>

                                        </tr>

                                    </tbody>

                                </table>

                            </div>

                            @error('products')
                                <p class="mt-3 text-xs text-red-500">{{ $message }}</p>
                            @enderror

                        </div>

                    </div>


                    <!-- COLONNE DROITE -->
                    <div class="space-y-6">


                        <!-- Source & Statut -->
                        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-6">

                            <!-- Source -->
                            <div>

                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">
                                    Source de la vente
                                </label>

                                <select name="source" id="order-source"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm font-bold bg-slate-50/50">

                                    <option value="manuelle"
                                        {{ old('source', 'manuelle') === 'manuelle' ? 'selected' : '' }}>
                                        Manuel
                                    </option>

                                    <option value="whatsapp" {{ old('source') === 'whatsapp' ? 'selected' : '' }}>
                                        WhatsApp
                                    </option>

                                    <option value="site_web" {{ old('source') === 'site_web' ? 'selected' : '' }}>
                                        Site Web
                                    </option>

                                    <option value="woocommerce"
                                        {{ old('source') === 'woocommerce' ? 'selected' : '' }}>
                                        WooCommerce
                                    </option>

                                </select>

                            </div>


                            <!-- Statut -->
                            <div>

                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">
                                    Statut Initial
                                </label>

                                <select name="status" id="order-status"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm font-bold bg-slate-50/50">

                                    @foreach (['En attente', 'Confirmée', 'Expédiée', 'Livrée', 'Annulée', 'Retournée'] as $status)
                                        <option value="{{ $status }}"
                                            {{ old('status', 'En attente') === $status ? 'selected' : '' }}>

                                            {{ $status }}

                                        </option>
                                    @endforeach

                                </select>

                            </div>


                            <!-- Livraison -->
                            <div>

                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">
                                    Frais de livraison
                                </label>

                                <div class="relative">

                                    <input type="number" name="shipping_cost" id="shipping-cost"
                                        value="{{ old('shipping_cost', 0) }}" min="0" step="0.01"
                                        oninput="calculateGlobalTotal()"
                                        class="w-full px-4 py-3 pr-16 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm font-bold bg-slate-50/50">

                                    <span
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400">
                                        DH
                                    </span>

                                </div>

                                @error('shipping_cost')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror

                            </div>

                        </div>


                        <!-- Résumé Financier -->
                        <div
                            class="bg-slate-900 p-8 rounded-3xl shadow-xl shadow-slate-200 text-white relative overflow-hidden">

                            <i data-lucide="calculator" class="absolute -right-4 -bottom-4 w-24 h-24 opacity-5"></i>

                            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-8">
                                Résumé de la commande
                            </h3>

                            <div class="space-y-4">

                                <!-- Subtotal -->
                                <div class="flex justify-between items-center text-sm">

                                    <span class="text-slate-400 font-medium">
                                        Sous-total
                                    </span>

                                    <span id="summary-subtotal" class="font-bold">
                                        0.00 DH
                                    </span>

                                </div>


                                <!-- Livraison -->
                                <div class="flex justify-between items-center text-sm">

                                    <span class="text-slate-400 font-medium">
                                        Livraison
                                    </span>

                                    <span id="summary-shipping" class="font-bold text-emerald-400">
                                        Gratuit
                                    </span>

                                </div>


                                <!-- Total -->
                                <div class="pt-4 border-t border-white/10 flex justify-between items-end">

                                    <span class="text-xs font-black uppercase tracking-widest">
                                        Total à payer
                                    </span>

                                    <span id="summary-total"
                                        class="text-3xl font-black text-indigo-400 tracking-tighter">

                                        0.00

                                        <span class="text-xs font-normal">
                                            DH
                                        </span>

                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </form>

        </main>

    </div>


    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <style>

    /* =========================================================
       SELECT2
       ========================================================= */

    .select2-container {
        max-width: 100%;
        min-width: 0;
    }

    .select2-container .select2-selection--single {
        height: 46px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        background: rgba(248, 250, 252, 0.5);
        overflow: hidden;
    }

    .select2-container .select2-selection--single
    .select2-selection__rendered {
        line-height: 44px;
        padding-left: 16px;
        padding-right: 35px;

        font-size: 14px;
        font-weight: 700;
        color: #334155;

        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .select2-container .select2-selection--single
    .select2-selection__arrow {
        height: 44px;
        right: 10px;
    }


    /* =========================================================
       FOCUS
       ========================================================= */

    .select2-container--default.select2-container--focus
    .select2-selection--single {
        border-color: #6366f1;
        box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.15);
    }


    /* =========================================================
       DROPDOWN
       ========================================================= */

    .select2-dropdown {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;

        box-sizing: border-box;
        max-width: calc(100vw - 32px);
    }


    /* =========================================================
       SEARCH
       ========================================================= */

    .select2-search {
        padding: 8px;
    }

    .select2-search__field {
        width: 100% !important;
        max-width: 100% !important;

        box-sizing: border-box !important;

        border-radius: 8px !important;
        border: 1px solid #e2e8f0 !important;

        outline: none !important;

        padding: 8px 10px !important;
    }


    /* =========================================================
       RESULTS
       ========================================================= */

    .select2-results {
        max-width: 100%;
        overflow-x: hidden;
    }

    .select2-results__options {
        max-width: 100%;
        overflow-x: hidden;
    }

    .select2-results__option {
        font-size: 14px;
        padding: 10px 12px;

        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .select2-results__option--highlighted {
        background: #4f46e5 !important;
    }


    /* =========================================================
       TABLE / PRODUCT SELECT
       ========================================================= */

    #products-table {
        width: 100%;
    }

    #products-table td {
        min-width: 0;
    }

    #products-table .select2-container {
        max-width: 100%;
        min-width: 0;
    }


    /* =========================================================
       MOBILE
       ========================================================= */

    @media (max-width: 640px) {

        .select2-dropdown {
            max-width: calc(100vw - 24px);
        }

        .select2-results__option {
            max-width: 100%;
        }

    }

</style>


    <script>
        lucide.createIcons();


        /*
        |--------------------------------------------------------------------------
        | Select2
        |--------------------------------------------------------------------------
        */

        function initSelect2(element) {

            $(element).select2({
                placeholder: '-- Choisir un produit --',
                allowClear: true,
                width: '100%'
            });

        }


        $(document).ready(function() {

            $('#order-client').select2({
                placeholder: '-- Choisir un client --',
                allowClear: true,
                width: '100%'
            });

            $('.product-select').each(function() {
                initSelect2(this);
            });

        });


        /*
        |--------------------------------------------------------------------------
        | Ajouter une ligne produit
        |--------------------------------------------------------------------------
        */

        function addProductRow() {

            const tbody = document.querySelector('#products-table tbody');
            const rows = document.querySelectorAll('.product-row');

            const index = rows.length;

            const firstRow = rows[0];
            const newRow = firstRow.cloneNode(true);

            const oldSelect = newRow.querySelector('.product-select');

            /*
            | Remove Select2 generated elements
            */

            newRow.querySelectorAll('.select2').forEach(element => {
                element.remove();
            });

            /*
            | Reset
            */

            oldSelect.value = '';

            oldSelect.name = `products[${index}][product_id]`;

            newRow.querySelector('.price-input').value = '0.00';

            newRow.querySelector('.qty-input').value = '1';

            newRow.querySelector('.qty-input').name =
                `products[${index}][quantity]`;

            newRow.querySelector('.row-total').innerText = '0.00';

            tbody.appendChild(newRow);

            /*
            | Initialize Select2
            */

            initSelect2(oldSelect);

            lucide.createIcons();

        }


        /*
        |--------------------------------------------------------------------------
        | Supprimer une ligne
        |--------------------------------------------------------------------------
        */

        function removeRow(button) {

            const rows = document.querySelectorAll('.product-row');

            if (rows.length <= 1) {

                Swal.fire({
                    icon: 'warning',
                    title: 'Attention',
                    text: 'Il faut au moins un produit.',
                    confirmButtonColor: '#4f46e5',
                    customClass: {
                        popup: 'rounded-3xl'
                    }
                });

                return;
            }

            const row = button.closest('tr');

            const select = row.querySelector('.product-select');

            if ($(select).hasClass('select2-hidden-accessible')) {
                $(select).select2('destroy');
            }

            row.remove();

            reindexProductRows();

            calculateGlobalTotal();

        }


        /*
        |--------------------------------------------------------------------------
        | Reindex products
        |--------------------------------------------------------------------------
        */

        function reindexProductRows() {

            document.querySelectorAll('.product-row').forEach((row, index) => {

                row.querySelector('.product-select').name =
                    `products[${index}][product_id]`;

                row.querySelector('.qty-input').name =
                    `products[${index}][quantity]`;

            });

        }


        /*
        |--------------------------------------------------------------------------
        | Product price
        |--------------------------------------------------------------------------
        */

        function updateRowPrice(select) {

            const row = select.closest('tr');

            const selectedOption =
                select.options[select.selectedIndex];

            const price =
                parseFloat(selectedOption?.dataset.price) || 0;

            row.querySelector('.price-input').value =
                price.toFixed(2);

            calculateRowTotal(
                row.querySelector('.qty-input')
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Row total
        |--------------------------------------------------------------------------
        */

        function calculateRowTotal(qtyInput) {

            const row = qtyInput.closest('tr');

            const price =
                parseFloat(
                    row.querySelector('.price-input').value
                ) || 0;

            const quantity =
                parseInt(qtyInput.value) || 0;

            const total =
                price * quantity;

            row.querySelector('.row-total').innerText =
                total.toFixed(2);

            calculateGlobalTotal();

        }


        /*
        |--------------------------------------------------------------------------
        | Global total
        |--------------------------------------------------------------------------
        */

        function calculateGlobalTotal() {

            let subtotal = 0;

            document.querySelectorAll('.row-total').forEach(span => {

                subtotal +=
                    parseFloat(span.innerText) || 0;

            });

            const shipping =
                parseFloat(
                    document.getElementById('shipping-cost').value
                ) || 0;

            const total =
                subtotal + shipping;


            /*
            | Subtotal
            */

            document.getElementById('summary-subtotal').innerText =
                subtotal.toFixed(2) + ' DH';


            /*
            | Shipping
            */

            const shippingElement =
                document.getElementById('summary-shipping');

            if (shipping > 0) {

                shippingElement.innerText =
                    shipping.toFixed(2) + ' DH';

                shippingElement.classList.remove(
                    'text-emerald-400'
                );

                shippingElement.classList.add(
                    'text-white'
                );

            } else {

                shippingElement.innerText =
                    'Gratuit';

                shippingElement.classList.remove(
                    'text-white'
                );

                shippingElement.classList.add(
                    'text-emerald-400'
                );

            }


            /*
            | Total
            */

            document.getElementById('summary-total').innerHTML =
                total.toFixed(2) +
                ' <span class="text-xs font-normal">DH</span>';

        }


        /*
        |--------------------------------------------------------------------------
        | Product change event
        |--------------------------------------------------------------------------
        */

        $(document).on('change', '.product-select', function() {

            updateRowPrice(this);

        });


        /*
        |--------------------------------------------------------------------------
        | Initial calculation
        |--------------------------------------------------------------------------
        */

        calculateGlobalTotal();
    </script>

</x-layout>
