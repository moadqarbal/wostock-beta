<x-layout>
    <style>
        /* Reçu مخفي فالشاشة */
        #thermal-receipt {
            display: none;
        }

        @media print {

            /* نخبيو الصفحة كاملة */
            body>* {
                display: none !important;
            }

            /* نظهرو غير reçu */
            #thermal-receipt {
                display: block !important;

                position: absolute !important;
                top: 0 !important;
                left: 0 !important;

                width: 80mm !important;
                margin: 0 !important;
                padding: 2mm !important;

                background: white !important;
                color: black !important;

                font-family: 'Courier New', Courier, monospace !important;
            }

            .receipt-container {
                width: 100% !important;
            }

            .receipt-header {
                text-align: center;
                margin-bottom: 5mm;
            }

            .receipt-brand {
                font-size: 16pt;
                font-weight: 900;
                text-transform: uppercase;
                margin: 0;
            }

            .receipt-divider {
                border-top: 1px dashed black;
                margin: 3mm 0;
                width: 100%;
            }

            .receipt-section {
                font-size: 10pt;
                line-height: 1.4;
                margin-bottom: 2mm;
            }

            .receipt-items {
                width: 100%;
                font-size: 10pt;
            }

            .item-row {
                display: flex;
                justify-content: space-between;
                margin-bottom: 1.5mm;
                align-items: flex-start;
            }

            .item-name {
                width: 75%;
            }

            .item-qty {
                width: 25%;
                text-align: right;
                font-weight: bold;
            }

            .receipt-footer {
                text-align: center;
                margin-top: 6mm;
                font-size: 9pt;
            }

            @page {
                size: 80mm auto;
                margin: 0;
            }
        }
    </style>
    <!-- MAIN CONTENT -->
    <div class="lg:ml-72 min-h-screen flex flex-col transition-all duration-300">
        <!-- NAVBAR -->
        <x-navigation.topbar />
        <!-- PAGE CONTENT -->
        <main class="p-4 lg:p-8 flex-grow w-full">
            <!-- En-tête -->
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                <div class="flex items-center gap-4">
                    <a href="{{ route('orders.index') }}"
                        class="p-2.5 bg-white border border-slate-200 rounded-xl text-slate-400 hover:text-indigo-600 transition-all shadow-sm">
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    </a>
                    <div>
                        <div
                            class="flex items-center gap-2 text-slate-500 text-[10px] uppercase font-black tracking-widest mb-1">
                            <span>Commandes</span>
                            <i data-lucide="chevron-right" class="w-3 h-3 text-slate-400"></i>
                            <span class="text-slate-900">
                                Détails Commande
                            </span>
                        </div>
                        <h1 class="text-2xl font-black text-slate-900 tracking-tight">
                            COMMANDE #{{ $order->order_number }}
                        </h1>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <!-- BOUTON IMPRIMER -->
                    <button onclick="window.print()"
                        class="p-2.5 bg-white border border-slate-200 rounded-xl text-slate-600 hover:bg-slate-50 transition-all"
                        title="Imprimer Reçu Thermique">
                        <i data-lucide="printer" class="w-5 h-5"></i>
                    </button>
                    <!-- BOUTON STATUT -->
                    <button onclick="changeStatus()"
                        class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all flex items-center gap-2">
                        <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                        Statut
                    </button>
                </div>
            </div>
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                <!-- =========================================
                     COLONNE GAUCHE
                ========================================== -->
                <div class="xl:col-span-2 space-y-6">
                    <!-- ARTICLES -->
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-slate-50 flex items-center justify-between bg-slate-50/30">
                            <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">
                                Articles commandés
                            </h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">
                                        <th class="px-6 py-4">
                                            Produit
                                        </th>
                                        <th class="px-6 py-4 text-center">
                                            Qté
                                        </th>
                                        <th class="px-6 py-4 text-right">
                                            Total
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @forelse ($order->items as $item)
                                        <tr>
                                            <td class="px-6 py-5 text-sm font-bold text-slate-800">
                                                {{ $item->product->name }}
                                            </td>
                                            <td class="px-6 py-5 text-center font-black text-slate-700 italic">
                                                x{{ $item->quantity }}
                                            </td>
                                            <td class="px-6 py-5 text-right font-black text-slate-900">
                                                {{ number_format($item->subtotal, 2, ',', ' ') }}
                                                DH
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-8 text-center text-sm text-slate-400">
                                                Aucun article dans cette commande.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- TIMELINE -->
                    <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-8">
                            Suivi
                        </h3>
                        <div
                            class="relative space-y-8 before:absolute before:inset-0 before:ml-5 before:h-full before:w-0.5 before:bg-slate-100">
                            <div class="relative flex items-center gap-6">
                                <div
                                    class="w-10 h-10 rounded-full bg-indigo-600 text-white flex items-center justify-center z-10 shadow-lg">
                                    <i data-lucide="check" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-black text-slate-800 uppercase">
                                        {{ $order->status }}
                                    </p>
                                    <p class="text-[10px] text-slate-400 font-bold">
                                        {{ $order->updated_at->format('d/m/Y - H:i') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- =========================================
                     COLONNE DROITE
                ========================================== -->
                <div class="space-y-6">
                    <!-- CLIENT -->
                    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">
                            Client
                        </h3>
                        <div class="flex items-center gap-4 mb-6">
                            <div
                                class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center font-black text-sm">
                                {{ strtoupper(substr($order->client->name, 0, 2)) }}
                            </div>
                            <div>
                                <h4 class="font-black text-slate-800 text-sm uppercase">
                                    {{ $order->client->name }}
                                </h4>
                                <p class="text-[10px] text-slate-400 font-bold italic">
                                    ID #CL-{{ $order->client->id }}
                                </p>
                            </div>
                        </div>
                        <div class="space-y-3 border-t border-slate-50 pt-6 font-bold text-slate-600 text-xs">
                            @if ($order->client->phone)
                                <p class="flex items-center gap-3">
                                    <i data-lucide="phone" class="w-4 h-4 text-indigo-400"></i>
                                    {{ $order->client->phone }}
                                </p>
                            @endif
                            @if ($order->client->address)
                                <p class="flex items-center gap-3">
                                    <i data-lucide="map-pin" class="w-4 h-4 text-indigo-400"></i>
                                    {{ $order->client->address }}
                                </p>
                            @endif
                        </div>
                    </div>
                    <!-- SOURCE & PAIEMENT -->
                    <div class="bg-slate-900 p-8 rounded-3xl shadow-xl text-white relative overflow-hidden">
                        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">
                            Source & Paiement
                        </h3>
                        <div class="flex justify-between items-center mb-8">
                            <div class="flex items-center gap-2">
                                @if ($order->source === 'whatsapp')
                                    <i data-lucide="message-circle" class="w-4 h-4 text-emerald-400"></i>
                                @elseif ($order->source === 'site_web')
                                    <i data-lucide="globe" class="w-4 h-4 text-emerald-400"></i>
                                @elseif ($order->source === 'woocommerce')
                                    <i data-lucide="shopping-cart" class="w-4 h-4 text-emerald-400"></i>
                                @else
                                    <i data-lucide="file-text" class="w-4 h-4 text-emerald-400"></i>
                                @endif
                                <span class="text-xs font-black uppercase">
                                    {{ str_replace('_', ' ', $order->source) }}
                                </span>
                            </div>
                            <p class="text-amber-400 text-xs font-black uppercase italic">
                                {{ $order->status }}
                            </p>
                        </div>
                        <!-- TOTAL DETAILS -->
                        <div class="space-y-3 pt-6 border-t border-white/10">
                            <div class="flex justify-between text-xs">
                                <span class="text-slate-400">
                                    Sous-total
                                </span>
                                <span class="font-bold">
                                    {{ number_format($order->subtotal, 2, ',', ' ') }}
                                    DH
                                </span>
                            </div>
                            <div class="flex justify-between text-xs">
                                <span class="text-slate-400">
                                    Livraison
                                </span>
                                <span class="font-bold">
                                    {{ number_format($order->shipping_cost, 2, ',', ' ') }}
                                    DH
                                </span>
                            </div>
                        </div>
                        <div class="mt-6 pt-6 border-t border-white/10 flex justify-between items-end">
                            <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">
                                Total
                            </span>
                            <h3 class="text-2xl font-black text-indigo-400 tracking-tighter">
                                {{ number_format($order->total_amount, 2, ',', ' ') }}
                                <span class="text-xs font-normal">
                                    DH
                                </span>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <!-- =============================================
         TEMPLATE REÇU THERMIQUE
         VISIBLE UNIQUEMENT À L'IMPRESSION
    ============================================== -->
    <div id="thermal-receipt">
        <div class="receipt-container">

            <div class="receipt-header">
                <h1 class="receipt-brand">WoStock beta</h1>
                <p style="font-size: 9pt; margin-top: 2px;">
                    GESTION D'INVENTAIRE
                </p>
            </div>

            <div class="receipt-section">
                <strong>COMMANDE :</strong> #{{ $order->order_number }}<br>
                <strong>DATE :</strong> {{ $order->created_at->format('d/m/Y H:i') }}
            </div>

            <div class="receipt-divider"></div>

            <div class="receipt-section">
                <strong>CLIENT :</strong><br>
                {{ $order->client->name }}<br>

                <strong>ADRESSE :</strong><br>
                {{ $order->client->address }}
            </div>

            <div class="receipt-divider"></div>

            <div class="receipt-items">

                <div class="item-row" style="font-weight: bold; border-bottom: 1px solid black; margin-bottom: 2mm;">
                    <span>PRODUIT</span>
                    <span>QTÉ</span>
                </div>

                @foreach ($order->items as $item)
                    <div class="item-row">
                        <span class="item-name">
                            {{ $item->product->name }}
                        </span>

                        <span class="item-qty">
                            x{{ $item->quantity }}
                        </span>
                    </div>
                @endforeach

            </div>

            <div class="receipt-divider"></div>

            <div class="receipt-section">

                <strong>SOUS-TOTAL :</strong>
                {{ number_format($order->subtotal, 2, ',', ' ') }} DH<br>

                <strong>LIVRAISON :</strong>
                {{ number_format($order->shipping_cost, 2, ',', ' ') }} DH

            </div>

            <div class="receipt-divider"></div>

            <div class="receipt-section" style="text-align: right; font-size: 12pt; font-weight: 900;">

                TOTAL : {{ number_format($order->total_amount, 2, ',', ' ') }} DH

            </div>

            <div class="receipt-footer">
                *** MERCI DE VOTRE VISITE ***<br>
                wobranding.com
            </div>

        </div>
    </div>
    <!-- =============================================
         JAVASCRIPT
    ============================================== -->
    <script>
        lucide.createIcons();

        function changeStatus() {
            Swal.fire({
                title: 'Mise à jour statut',
                input: 'select',
                inputOptions: @json(collect($statuses)->mapWithKeys(fn($status) => [$status => $status])),
                inputValue: @json($order->status),
                confirmButtonText: 'Enregistrer',
                cancelButtonText: 'Annuler',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                customClass: {
                    popup: 'rounded-3xl'
                }
            }).then((result) => {
                if (!result.isConfirmed) {
                    return;
                }
                fetch('{{ route('orders.update-status', $order) }}', {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            status: result.value
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Statut mis à jour',
                                text: data.message,
                                confirmButtonColor: '#4f46e5',
                                customClass: {
                                    popup: 'rounded-3xl'
                                }
                            }).then(() => {
                                window.location.reload();
                            });
                        }
                    })
                    .catch(() => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: 'Impossible de mettre à jour le statut.',
                            confirmButtonColor: '#4f46e5',
                            customClass: {
                                popup: 'rounded-3xl'
                            }
                        });
                    });
            });
        }
    </script>
</x-layout>
