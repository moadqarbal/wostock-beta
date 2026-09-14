<x-layout>
    <div class="lg:ml-72 min-h-screen flex flex-col transition-all duration-300">
        <x-navigation.topbar />
        <main class="p-4 lg:p-8 flex-grow">
            {{-- Header --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                <div class="flex items-center gap-4">
                    <a
                        href="{{ route('clients.index') }}"
                        class="p-2.5 bg-white border border-slate-200 rounded-xl text-slate-400 hover:text-indigo-600 hover:border-indigo-100 transition-all"
                    >
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    </a>
                    <div>
                        <div class="flex items-center gap-2 text-slate-500 text-xs mb-1">
                            <span>Clients</span>
                            <i data-lucide="chevron-right" class="w-3 h-3"></i>
                            <span class="text-slate-900 font-medium">
                                Fiche Client
                            </span>
                        </div>
                        <h1 class="text-2xl font-bold text-slate-900 uppercase tracking-tight">
                            {{ $client->name }}
                        </h1>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a
                        href="{{ route('clients.edit', $client) }}"
                        class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-slate-600 text-sm font-bold hover:bg-slate-50 flex items-center gap-2"
                    >
                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                        Modifier
                    </a>
                    <a
                        href=""
                        class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 flex items-center gap-2"
                    >
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        Nouvelle Commande
                    </a>
                </div>
            </div>
            {{-- Client info + stats --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                {{-- Profile --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col items-center text-center">
                    @php
                        $initials = collect(
                            preg_split('/\s+/', trim($client->name))
                        )
                        ->filter()
                        ->take(2)
                        ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
                        ->implode('');
                        if ($initials === '') {
                            $initials = '?';
                        }
                    @endphp
                    <div class="w-24 h-24 rounded-full bg-indigo-50 border-4 border-white shadow-sm flex items-center justify-center text-indigo-600 text-3xl font-black mb-4">
                        {{ $initials }}
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">
                        {{ $client->name }}
                    </h3>
                    <p class="text-sm text-slate-400 mb-6">
                        Client depuis {{ $client->created_at->translatedFormat('F Y') }}
                    </p>
                    <div class="w-full space-y-3 text-left border-t border-slate-50 pt-6">
                        @if ($client->phone)
                            <div class="flex items-center gap-3">
                                <i data-lucide="phone" class="w-4 h-4 text-slate-400"></i>
                                <span class="text-sm font-medium text-slate-600">
                                    {{ $client->phone }}
                                </span>
                            </div>
                        @endif
                        @if ($client->email)
                            <div class="flex items-center gap-3">
                                <i data-lucide="mail" class="w-4 h-4 text-slate-400"></i>
                                <span class="text-sm font-medium text-slate-600">
                                    {{ $client->email }}
                                </span>
                            </div>
                        @endif
                        @if ($client->address)
                            <div class="flex items-start gap-3">
                                <i data-lucide="map-pin" class="w-4 h-4 text-slate-400 mt-0.5"></i>
                                <span class="text-sm font-medium text-slate-600">
                                    {{ $client->address }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
                {{-- Stats --}}
                <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Total --}}
                    <div class="bg-indigo-600 p-8 rounded-3xl shadow-lg shadow-indigo-200 text-white flex flex-col justify-between md:row-span-2 relative overflow-hidden group">
                        <i
                            data-lucide="wallet"
                            class="w-24 h-24 absolute -right-6 -bottom-6 opacity-20 group-hover:scale-110 transition-transform duration-500"
                        ></i>
                        <div class="relative z-10">
                            <div class="p-3 bg-white/10 w-fit rounded-2xl mb-4">
                                <i data-lucide="wallet" class="w-6 h-6"></i>
                            </div>
                            <p class="text-indigo-100 text-xs font-bold uppercase tracking-widest">
                                Chiffre d'Affaires Total
                            </p>
                        </div>
                        <div class="relative z-10 mt-12">
                            <h3 class="text-4xl font-black tracking-tighter">
                                {{ number_format($client->orders->sum('total_amount'), 2, '.', ',') }}
                                <span class="text-sm font-medium opacity-70">
                                    DH
                                </span>
                            </h3>
                        </div>
                    </div>
                    {{-- Orders --}}
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center gap-5">
                        <div class="p-4 bg-slate-50 text-indigo-500 rounded-2xl">
                            <i data-lucide="shopping-bag" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-1">
                                Commandes
                            </p>
                            <h3 class="text-2xl font-black text-slate-800 tracking-tight">
                                {{ $client->orders->count() }}
                            </h3>
                        </div>
                    </div>
                    {{-- Last order --}}
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center gap-5">
                        <div class="p-4 bg-slate-50 text-amber-500 rounded-2xl">
                            <i data-lucide="clock" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-1">
                                Dernier Achat
                            </p>
                            @php
                                $lastOrder = $client->orders->sortByDesc('created_at')->first();
                            @endphp
                            @if ($lastOrder)
                                <h3 class="text-lg font-black text-slate-800 tracking-tight">
                                    {{ $lastOrder->created_at->translatedFormat('d F Y') }}
                                </h3>
                            @else
                                <h3 class="text-lg font-black text-slate-400">
                                    Aucun achat
                                </h3>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            {{-- Orders history --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                {{-- Header --}}
                <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4">
                    <h3 class="text-lg font-bold text-slate-800">
                        Historique des Commandes
                    </h3>
                    <div class="flex items-center gap-3 w-full md:w-auto">
                        {{-- Search --}}
                        <div class="relative flex-grow">
                            <i
                                data-lucide="search"
                                class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"
                            ></i>
                            <input
                                type="text"
                                id="orderSearch"
                                onkeyup="filterOrders()"
                                placeholder="N° Commande..."
                                class="w-full md:w-64 pl-10 pr-4 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all"
                            >
                        </div>
                        {{-- Status filter --}}
                        <select
                            id="statusFilter"
                            onchange="filterOrders()"
                            class="bg-slate-50 border border-slate-200 text-slate-600 text-xs rounded-xl px-4 py-2 outline-none"
                        >
                            <option value="">
                                Tous les statuts
                            </option>
                            <option value="En attente">
                                En attente
                            </option>
                            <option value="Confirmée">
                                Confirmée
                            </option>
                            <option value="Expédiée">
                                Expédiée
                            </option>
                            <option value="Livrée">
                                Livrée
                            </option>
                            <option value="Annulée">
                                Annulée
                            </option>
                            <option value="Retournée">
                                Retournée
                            </option>
                        </select>
                    </div>
                </div>
                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table
                        class="w-full text-left border-collapse"
                        id="ordersTable"
                    >
                        <thead>
                            <tr class="bg-slate-50/50 text-slate-500 text-[10px] uppercase font-black tracking-widest border-b border-slate-100">
                                <th class="px-6 py-4">
                                    N° Commande
                                </th>
                                <th class="px-6 py-4">
                                    Date
                                </th>
                                <th class="px-6 py-4">
                                    Total
                                </th>
                                <th class="px-6 py-4 text-center">
                                    Statut
                                </th>
                                <th class="px-6 py-4 text-right">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse ($client->orders->sortByDesc('created_at') as $order)
                                @php
                                    $statusClasses = match ($order->status) {
                                        'En attente' => 'bg-amber-100 text-amber-700',
                                        'Confirmée' => 'bg-blue-100 text-blue-700',
                                        'Expédiée' => 'bg-indigo-100 text-indigo-700',
                                        'Livrée' => 'bg-emerald-100 text-emerald-700',
                                        'Annulée' => 'bg-red-100 text-red-700',
                                        'Retournée' => 'bg-slate-100 text-slate-700',
                                        default => 'bg-slate-100 text-slate-700',
                                    };
                                @endphp
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    {{-- Order number --}}
                                    <td class="px-6 py-4 font-bold text-slate-700 text-sm">
                                        #{{ $order->order_number }}
                                    </td>
                                    {{-- Date --}}
                                    <td class="px-6 py-4 text-slate-500 text-sm">
                                        {{ $order->created_at->translatedFormat('d F Y') }}
                                    </td>
                                    {{-- Total --}}
                                    <td class="px-6 py-4 font-bold text-slate-900 text-sm">
                                        {{ number_format($order->total_amount, 2, '.', ',') }}
                                        DH
                                    </td>
                                    {{-- Status --}}
                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="status-badge px-2.5 py-1 rounded-lg text-[10px] font-black uppercase {{ $statusClasses }}"
                                            data-status="{{ $order->status }}"
                                        >
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    {{-- Actions --}}
                                    <td class="px-6 py-4 text-right">
                                        <a
                                            href=""
                                            class="inline-flex p-2 text-slate-400 hover:text-indigo-600 transition-colors"
                                        >
                                            <i data-lucide="external-link" class="w-4 h-4"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td
                                        colspan="5"
                                        class="px-6 py-12 text-center text-sm text-slate-400"
                                    >
                                        Aucune commande trouvée pour ce client.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    {{-- Scripts --}}
    <script>
        lucide.createIcons();
        function filterOrders() {
            const searchInput = document
                .getElementById('orderSearch')
                .value
                .toLowerCase();
            const statusFilter = document
                .getElementById('statusFilter')
                .value
                .toLowerCase();
            const rows = document.querySelectorAll(
                '#ordersTable tbody tr'
            );
            rows.forEach(row => {
                const orderNumber = row
                    .cells[0]
                    ?.textContent
                    .toLowerCase() ?? '';
                const status = row
                    .querySelector('.status-badge')
                    ?.dataset.status
                    ?.toLowerCase() ?? '';
                const matchesSearch =
                    orderNumber.includes(searchInput);
                const matchesStatus =
                    statusFilter === '' ||
                    status === statusFilter;
                row.style.display =
                    matchesSearch && matchesStatus
                        ? ''
                        : 'none';
            });
        }
    </script>
</x-layout>