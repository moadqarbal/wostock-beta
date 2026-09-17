<x-layout>
    <!-- MAIN CONTENT -->
    <div class="lg:ml-72 min-h-screen flex flex-col transition-all duration-300">

        <!-- NAVBAR -->
        <x-navigation.topbar />

        <!-- PAGE CONTENT -->
        <main class="p-4 lg:p-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Tableau de Bord</h1>
                    <p class="text-slate-500 text-sm">Bienvenue sur votre interface de gestion WoStock.</p>
                </div>
                <div class="flex items-center gap-3">

                    <a href="{{ route('products.create') }}"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-indigo-700 shadow-lg shadow-indigo-600/20 transition-all flex items-center gap-2">
                        <i data-lucide="plus" class="w-4 h-4"></i> Nouveau Produit
                    </a>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
                <!-- Carte Stat 1 -->
                <div
                    class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                            <i data-lucide="shopping-cart" class="w-6 h-6"></i>
                        </div>
                        <span class="text-green-500 bg-green-50 px-2 py-1 rounded-lg text-xs font-bold">+12%</span>
                    </div>
                    <p class="text-slate-500 text-sm font-medium">
                        Commandes du jour
                    </p>

                    <h3 class="text-2xl font-bold text-slate-800">
                        {{ $todayOrders }}
                    </h3>

                </div>
                <!-- Vous pouvez ajouter d'autres cartes ici -->
            </div>

            <!-- Table illustrative -->

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">

                <div class="p-6 border-b border-slate-100 font-bold text-slate-800">
                    Dernières Commandes Passées
                </div>

                @forelse ($orders as $orders)
                    <div class="flex items-center justify-between p-6 border-b border-slate-100">
                        <div>
                            <h3 class="font-semibold text-slate-800">
                                {{ $orders->order_number }}
                            </h3>

                            <p class="text-sm text-slate-500">
                                {{ $orders->status }}
                            </p>
                        </div>

                        <span class="font-semibold">
                            {{ $orders->total_amount }} DH
                        </span>
                    </div>

                @empty

                    <div class="p-12 text-center text-slate-400">
                        <i data-lucide="package-search" class="w-12 h-12 mx-auto mb-4 opacity-20"></i>

                        <p>Aucun produit ajouté pour le moment.</p>
                    </div>
                @endforelse

            </div>


        </main>
    </div>
</x-layout>
