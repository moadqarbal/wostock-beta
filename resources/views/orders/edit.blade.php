<x-layout>
    <div class="lg:ml-72 min-h-screen flex flex-col transition-all duration-300">
        <x-navigation.topbar />
        <main class="flex-1 p-6">
            {{-- Header --}}
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        Modifier la commande
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Commande #{{ $order->order_number }}
                    </p>
                </div>
                <a href="{{ route('orders.show', $order) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Retour
                </a>
            </div>
            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <ul class="text-sm text-red-600 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form id="order-form" action="{{ route('orders.update', $order) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {{-- Main --}}
                    <div class="lg:col-span-2 space-y-6">
                        {{-- Client --}}
                        <div class="bg-white rounded-xl border border-gray-200 p-6">
                            <h2 class="text-lg font-semibold text-gray-900 mb-5">
                                Informations de la commande
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                {{-- Client --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Client
                                    </label>
                                    <select name="client_id" id="client-select"  class="w-full">
                                        <option value="">Sélectionner un client</option>

                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}" @selected(old('client_id', $order->client_id) == $client->id)>
                                                {{ $client->name }}
                                                @if ($client->phone)
                                                    — {{ $client->phone }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- Source --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Source
                                    </label>
                                    <select name="source" 
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-black">
                                        <option value="manuelle" @selected(old('source', $order->source) === 'manuelle')>
                                            Manuelle
                                        </option>
                                        <option value="whatsapp" @selected(old('source', $order->source) === 'whatsapp')>
                                            WhatsApp
                                        </option>
                                        <option value="site_web" @selected(old('source', $order->source) === 'site_web')>
                                            Site web
                                        </option>
                                        <option value="woocommerce" @selected(old('source', $order->source) === 'woocommerce')>
                                            WooCommerce
                                        </option>
                                    </select>
                                </div>
                                {{-- Shipping --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Frais de livraison
                                    </label>
                                    <div class="relative">
                                        <input type="number" name="shipping_cost" id="shipping-cost"
                                            value="{{ old('shipping_cost', $order->shipping_cost) }}" min="0"
                                            step="0.01" oninput="calculateGlobalTotal()" 
                                            class="w-full px-4 py-2.5 pr-14 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-black">
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm text-gray-500">
                                            DH
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Products --}}
                        <div class="bg-white rounded-xl border border-gray-200 p-6">
                            <div class="flex items-center justify-between mb-5">
                                <div>
                                    <h2 class="text-lg font-semibold text-gray-900">
                                        Produits
                                    </h2>
                                    <p class="text-sm text-gray-500 mt-1">
                                        Ajoutez les produits de la commande
                                    </p>
                                </div>
                                <button type="button" onclick="addProductRow()"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-black text-white text-sm font-medium rounded-lg hover:bg-gray-800">
                                    <i data-lucide="plus" class="w-4 h-4"></i>
                                    Ajouter
                                </button>
                            </div>
                            <div id="products-container" class="space-y-4">
                                @foreach ($order->items as $index => $item)
                                    <div class="product-row grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
                                        {{-- Product --}}
                                        <div class="md:col-span-6">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Produit
                                            </label>
                                            <select name="products[{{ $index }}][product_id]"
                                                class="product-select w-full" onchange="calculateGlobalTotal()"
                                                >
                                                <option value="">Sélectionner un produit</option>

                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}"
                                                        data-price="{{ $product->price }}"
                                                        @selected($item->product_id == $product->id)>
                                                        {{ $product->name }}
                                                        — {{ $product->sku }}
                                                        — {{ number_format($product->price, 2) }} DH
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {{-- Quantity --}}
                                        <div class="md:col-span-3">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Quantité
                                            </label>
                                            <input type="number" name="products[{{ $index }}][quantity]"
                                                value="{{ old("products.$index.quantity", $item->quantity) }}"
                                                min="1" 
                                                class="quantity-input w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-black"
                                                oninput="calculateGlobalTotal()">
                                        </div>
                                        {{-- Subtotal --}}
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Sous-total
                                            </label>
                                            <div
                                                class="item-subtotal px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm font-medium">
                                                {{ number_format($item->subtotal, 2) }} DH
                                            </div>
                                        </div>
                                        {{-- Remove --}}
                                        <div class="md:col-span-1">
                                            <button type="button" onclick="removeProductRow(this)"
                                                class="w-full h-[42px] flex items-center justify-center text-red-600 bg-red-50 rounded-lg hover:bg-red-100">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    {{-- Summary --}}
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-xl border border-gray-200 p-6 sticky top-6">
                            <h2 class="text-lg font-semibold text-gray-900 mb-5">
                                Résumé
                            </h2>
                            <div class="space-y-4">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">
                                        Sous-total
                                    </span>
                                    <span id="summary-subtotal" class="font-medium text-gray-900">
                                        {{ number_format($order->subtotal, 2) }} DH
                                    </span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">
                                        Livraison
                                    </span>
                                    <span id="summary-shipping" class="font-medium text-gray-900">
                                        {{ number_format($order->shipping_cost, 2) }} DH
                                    </span>
                                </div>
                                <div class="border-t border-gray-200 pt-4">
                                    <div class="flex justify-between">
                                        <span class="font-semibold text-gray-900">
                                            Total
                                        </span>
                                        <span id="summary-total" class="text-xl font-bold text-gray-900">
                                            {{ number_format($order->total_amount, 2) }} DH
                                        </span>
                                    </div>
                                </div>
                            </div>
                            {{-- Submit --}}
                            <button type="submit"
                                class="w-full mt-6 inline-flex items-center justify-center gap-2 px-5 py-3 bg-black text-white font-medium rounded-lg hover:bg-gray-800">
                                <i data-lucide="save" class="w-4 h-4"></i>
                                Enregistrer les modifications
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        function initSelect2() {
            $('#client-select').select2({
                placeholder: 'Sélectionner un client',
                allowClear: true,
                width: '100%'
            });

            $('.product-select:not(.select2-hidden-accessible)').select2({
                placeholder: 'Sélectionner un produit',
                width: '100%'
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            initSelect2();
        });
    </script>

    <script>
        let productIndex = {{ $order->items->count() }};

        function calculateGlobalTotal() {
            let subtotal = 0;
            document.querySelectorAll('.product-row').forEach(row => {
                const select = row.querySelector('.product-select');
                const quantityInput = row.querySelector('.quantity-input');
                const subtotalElement = row.querySelector('.item-subtotal');
                if (!select || !quantityInput) {
                    return;
                }
                const selectedOption =
                    select.options[select.selectedIndex];
                const price =
                    parseFloat(
                        selectedOption?.dataset.price
                    ) || 0;
                const quantity =
                    parseInt(quantityInput.value) || 0;
                const itemSubtotal =
                    price * quantity;
                subtotal += itemSubtotal;
                if (subtotalElement) {
                    subtotalElement.textContent =
                        itemSubtotal.toFixed(2) + ' DH';
                }
            });
            const shipping =
                parseFloat(
                    document.getElementById('shipping-cost').value
                ) || 0;
            const total =
                subtotal + shipping;
            document.getElementById('summary-subtotal').textContent =
                subtotal.toFixed(2) + ' DH';
            document.getElementById('summary-shipping').textContent =
                shipping.toFixed(2) + ' DH';
            document.getElementById('summary-total').textContent =
                total.toFixed(2) + ' DH';
        }

        function addProductRow() {
            const container =
                document.getElementById('products-container');
            const row = document.createElement('div');
            row.className =
                'product-row grid grid-cols-1 md:grid-cols-12 gap-3 items-end';
            row.innerHTML = `
                <div class="md:col-span-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Produit
                    </label>
                    <select
                        name="products[${productIndex}][product_id]"
                        class="product-select w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-black"
                        onchange="calculateGlobalTotal()"
                        
                    >
                        <option value="">
                            Sélectionner un produit
                        </option>
                        @foreach ($products as $product)
                            <option
                                value="{{ $product->id }}"
                                data-price="{{ $product->price }}"
                            >
                                {{ $product->name }}
                                — {{ number_format($product->price, 2) }} DH
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Quantité
                    </label>
                    <input
                        type="number"
                        name="products[${productIndex}][quantity]"
                        value="1"
                        min="1"
                        
                        class="quantity-input w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-black"
                        oninput="calculateGlobalTotal()"
                    >
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Sous-total
                    </label>
                    <div class="item-subtotal px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm font-medium">
                        0.00 DH
                    </div>
                </div>
                <div class="md:col-span-1">
                    <button
                        type="button"
                        onclick="removeProductRow(this)"
                        class="w-full h-[42px] flex items-center justify-center text-red-600 bg-red-50 rounded-lg hover:bg-red-100"
                    >
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                </div>
            `;
            container.appendChild(row);
            productIndex++;
            if (window.lucide) {
                lucide.createIcons();
            }
            calculateGlobalTotal();
        }

        function removeProductRow(button) {
            const rows =
                document.querySelectorAll('.product-row');
            if (rows.length <= 1) {
                return;
            }
            button.closest('.product-row').remove();
            calculateGlobalTotal();
        }
        document.addEventListener('DOMContentLoaded', function() {
            calculateGlobalTotal();
            if (window.lucide) {
                lucide.createIcons();
            }
        });
    </script>
</x-layout>
