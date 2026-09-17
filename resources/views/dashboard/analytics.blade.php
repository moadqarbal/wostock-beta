<x-layout>
    <div class="lg:ml-72 min-h-screen flex flex-col transition-all duration-300">
        <x-navigation.topbar />
        <main class="flex-1 p-6 lg:p-8">
            {{-- Page Header --}}
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        Analyses & Rapports
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Performances globales de WoStock beta.
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <form method="GET" action="{{ route('dashboard.analytics') }}">

                        <select name="period" onchange="this.form.submit()"
                            class="px-4 py-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-200">

                            <option value="7" @selected($period === '7')>
                                7 jours
                            </option>

                            <option value="30" @selected($period === '30')>
                                1 mois
                            </option>

                            <option value="90" @selected($period === '90')>
                                3 mois
                            </option>

                            <option value="all" @selected($period === 'all')>
                                Tout le temps
                            </option>

                        </select>

                    </form>
                    <a href="{{ route('dashboard.analytics.export', ['period' => $period]) }}"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-lg bg-green-600 text-white hover:bg-green-700 transition-all shadow-sm">

                        <i data-lucide="file-spreadsheet" class="w-4 h-4"></i>

                        Exporter CSV
                    </a>
                </div>
            </div>
            {{-- KPI Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">
                {{-- Chiffre d'affaires --}}
                <div class="bg-white border border-gray-200 rounded-xl p-5">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center">
                            <i data-lucide="banknote" class="w-5 h-5 text-green-600"></i>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500">
                        C.A Global
                    </p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">
                        {{ number_format($totalRevenue, 2, '.', ' ') }} DH
                    </p>
                </div>
                {{-- Commandes --}}
                <div class="bg-white border border-gray-200 rounded-xl p-5">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                            <i data-lucide="shopping-cart" class="w-5 h-5 text-blue-600"></i>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500">
                        Commandes
                    </p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">
                        {{ number_format($totalOrders) }}
                    </p>
                </div>
                {{-- Panier moyen --}}
                <div class="bg-white border border-gray-200 rounded-xl p-5">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center">
                            <i data-lucide="receipt" class="w-5 h-5 text-purple-600"></i>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500">
                        Panier Moyen
                    </p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">
                        {{ number_format($averageOrder, 2, '.', ' ') }} DH
                    </p>
                </div>
                {{-- Nouveaux clients --}}
                <div class="bg-white border border-gray-200 rounded-xl p-5">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 rounded-lg bg-orange-50 flex items-center justify-center">
                            <i data-lucide="user-plus" class="w-5 h-5 text-orange-600"></i>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500">
                        Nouveaux Clients
                    </p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">
                        +{{ number_format($newClients) }}
                    </p>
                </div>
            </div>
            {{-- Charts --}}
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-8">
                {{-- Revenue --}}
                <div class="xl:col-span-2 bg-white border border-gray-200 rounded-xl p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-base font-semibold text-gray-900">
                                Évolution du chiffre d'affaires
                            </h2>
                            <p class="text-sm text-gray-500 mt-1">
                                Revenus des 7 derniers jours
                            </p>
                        </div>
                        <div class="w-9 h-9 rounded-lg bg-gray-50 flex items-center justify-center">
                            <i data-lucide="trending-up" class="w-5 h-5 text-gray-600"></i>
                        </div>
                    </div>
                    <div class="relative h-80">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
                {{-- Sources --}}
                <div class="bg-white border border-gray-200 rounded-xl p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-base font-semibold text-gray-900">
                                Sources des commandes
                            </h2>
                            <p class="text-sm text-gray-500 mt-1">
                                Répartition par source
                            </p>
                        </div>
                        <div class="w-9 h-9 rounded-lg bg-gray-50 flex items-center justify-center">
                            <i data-lucide="pie-chart" class="w-5 h-5 text-gray-600"></i>
                        </div>
                    </div>
                    <div class="relative h-64">
                        <canvas id="sourceChart"></canvas>
                    </div>
                    <div class="grid grid-cols-2 gap-3 mt-6">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>
                            <span class="text-xs text-gray-600">
                                WhatsApp
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                            <span class="text-xs text-gray-600">
                                WooCommerce
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-yellow-500"></span>
                            <span class="text-xs text-gray-600">
                                Manuelle
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span>
                            <span class="text-xs text-gray-600">
                                Site Web
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Lists --}}
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                {{-- Top Produits --}}
                <div class="bg-white border border-gray-200 rounded-xl">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-base font-semibold text-gray-900">
                                    Top Produits
                                </h2>
                                <p class="text-sm text-gray-500 mt-1">
                                    Produits les plus vendus
                                </p>
                            </div>
                            <div class="w-9 h-9 rounded-lg bg-gray-50 flex items-center justify-center">
                                <i data-lucide="package" class="w-5 h-5 text-gray-600"></i>
                            </div>
                        </div>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @forelse ($topProducts as $index => $item)
                            <div class="flex items-center gap-4 p-5">
                                {{-- Rank --}}
                                <div class="w-9 h-9 rounded-lg bg-gray-100 flex items-center justify-center shrink-0">
                                    <span class="text-sm font-semibold text-gray-700">
                                        {{ $index + 1 }}
                                    </span>
                                </div>
                                {{-- Product --}}
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 truncate">
                                        {{ $item->product?->name ?? 'Produit supprimé' }}
                                    </p>
                                    @if ($item->product)
                                        <p class="text-xs text-gray-500 mt-1">
                                            SKU: {{ $item->product->sku }}
                                        </p>
                                    @endif
                                </div>
                                {{-- Quantity --}}
                                <div class="text-right">
                                    <p class="text-sm font-semibold text-gray-900">
                                        {{ number_format($item->total_quantity) }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        ventes
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center">
                                <i data-lucide="package-open" class="w-8 h-8 mx-auto text-gray-300"></i>
                                <p class="text-sm text-gray-500 mt-3">
                                    Aucun produit vendu pendant cette période.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
                {{-- Stock critique --}}
                <div class="bg-white border border-gray-200 rounded-xl">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-base font-semibold text-gray-900">
                                    Stock Critique
                                </h2>
                                <p class="text-sm text-gray-500 mt-1">
                                    Produits nécessitant un réapprovisionnement
                                </p>
                            </div>
                            <div class="w-9 h-9 rounded-lg bg-red-50 flex items-center justify-center">
                                <i data-lucide="triangle-alert" class="w-5 h-5 text-red-600"></i>
                            </div>
                        </div>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @forelse ($criticalProducts as $product)
                            <div class="flex items-center gap-4 p-5">
                                {{-- Icon --}}
                                <div class="w-10 h-10 rounded-lg bg-red-50 flex items-center justify-center shrink-0">
                                    <i data-lucide="package" class="w-5 h-5 text-red-500"></i>
                                </div>
                                {{-- Product --}}
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 truncate">
                                        {{ $product->name }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        SKU: {{ $product->sku }}
                                    </p>
                                    @if ($product->supplier)
                                        <p class="text-xs text-gray-400 mt-1">
                                            {{ $product->supplier->company_name }}
                                        </p>
                                    @endif
                                </div>
                                {{-- Stock --}}
                                <div class="text-right">
                                    <p class="text-sm font-bold text-red-600">
                                        {{ number_format($product->stock_quantity) }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        unités
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center">
                                <i data-lucide="circle-check" class="w-8 h-8 mx-auto text-green-500"></i>
                                <p class="text-sm text-gray-500 mt-3">
                                    Aucun produit en stock critique.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </main>
    </div>
    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            /*
            |--------------------------------------------------------------------------
            | Revenue Chart
            |--------------------------------------------------------------------------
            */
            const revenueCanvas = document.getElementById('revenueChart');
            if (revenueCanvas) {
                const revenueLabels = @json(collect($revenueChart)->pluck('label')->values());
                const revenueData = @json(collect($revenueChart)->pluck('revenue')->values());
                new Chart(revenueCanvas, {
                    type: 'line',
                    data: {
                        labels: revenueLabels,
                        datasets: [{
                            label: 'Chiffre d’affaires',
                            data: revenueData,
                            borderWidth: 2,
                            tension: 0.35,
                            fill: true,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return Number(context.raw)
                                            .toLocaleString('fr-FR', {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            }) + ' DH';
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return Number(value)
                                            .toLocaleString('fr-FR') + ' DH';
                                    }
                                },
                                grid: {
                                    drawBorder: false
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }
            /*
            |--------------------------------------------------------------------------
            | Source Chart
            |--------------------------------------------------------------------------
            */
            const sourceCanvas = document.getElementById('sourceChart');
            if (sourceCanvas) {
                const sourceData = [
                    {{ $sourceChart['whatsapp'] }},
                    {{ $sourceChart['woocommerce'] }},
                    {{ $sourceChart['manuelle'] }},
                    {{ $sourceChart['site_web'] }}
                ];
                new Chart(sourceCanvas, {
                    type: 'doughnut',
                    data: {
                        labels: [
                            'WhatsApp',
                            'WooCommerce',
                            'Manuelle',
                            'Site Web'
                        ],
                        datasets: [{
                            data: sourceData,
                            borderWidth: 0,
                            hoverOffset: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const total = context.dataset.data.reduce(
                                            (sum, value) => sum + Number(value),
                                            0
                                        );
                                        const value = Number(context.raw);
                                        const percentage = total > 0 ?
                                            ((value / total) * 100).toFixed(1) :
                                            0;
                                        return `${context.label}: ${value} (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            }
            /*
            |--------------------------------------------------------------------------
            | Lucide Icons
            |--------------------------------------------------------------------------
            */
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>
</x-layout>
