<x-layout>

    <div class="lg:ml-72 min-h-screen flex flex-col transition-all duration-300">

        <x-navigation.topbar />

        <main class="p-4 lg:p-8 flex-grow">

            {{-- Header --}}
            <div class="flex items-center gap-4 mb-8">

                <a
                    href="{{ route('clients.show', $client) }}"
                    class="p-2.5 bg-white border border-slate-200 rounded-xl text-slate-400 hover:text-indigo-600 hover:border-indigo-100 transition-all"
                >
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>

                <div>

                    <div class="flex items-center gap-2 text-slate-500 text-xs mb-1">

                        <a
                            href="{{ route('clients.index') }}"
                            class="hover:text-indigo-600 transition-colors"
                        >
                            Clients
                        </a>

                        <i data-lucide="chevron-right" class="w-3 h-3"></i>

                        <a
                            href="{{ route('clients.show', $client) }}"
                            class="hover:text-indigo-600 transition-colors"
                        >
                            {{ $client->name }}
                        </a>

                        <i data-lucide="chevron-right" class="w-3 h-3"></i>

                        <span class="text-slate-900 font-medium">
                            Modifier
                        </span>

                    </div>

                    <h1 class="text-2xl font-bold text-slate-900 tracking-tight">
                        Modifier le client
                    </h1>

                </div>

            </div>


            {{-- Content --}}
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

                {{-- Edit Form --}}
                <div class="xl:col-span-2">

                    <form
                        action="{{ route('clients.update', $client) }}"
                        method="POST"
                        class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden"
                    >

                        @csrf
                        @method('PUT')


                        {{-- Form Header --}}
                        <div class="p-6 border-b border-slate-100">

                            <div class="flex items-center gap-4">

                                <div class="w-14 h-14 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 text-lg font-black">

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

                                    {{ $initials }}

                                </div>

                                <div>

                                    <h2 class="text-lg font-bold text-slate-800">
                                        Informations du client
                                    </h2>

                                    <p class="text-sm text-slate-400">
                                        Modifiez les informations de {{ $client->name }}.
                                    </p>

                                </div>

                            </div>

                        </div>


                        {{-- Fields --}}
                        <div class="p-6 space-y-6">

                            {{-- Name --}}
                            <div>

                                <label
                                    for="name"
                                    class="block text-sm font-semibold text-slate-700 mb-2"
                                >
                                    Nom complet
                                    <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name', $client->name) }}"
                                
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm text-slate-700 outline-none transition-all focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                                    placeholder="Nom complet"
                                >

                                @error('name')
                                    <p class="mt-2 text-sm text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- Phone + Email --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                {{-- Phone --}}
                                <div>

                                    <label
                                        for="phone"
                                        class="block text-sm font-semibold text-slate-700 mb-2"
                                    >
                                        Téléphone
                                    </label>

                                    <div class="relative">

                                        <i
                                            data-lucide="phone"
                                            class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"
                                        ></i>

                                        <input
                                            type="text"
                                            id="phone"
                                            name="phone"
                                            value="{{ old('phone', $client->phone) }}"
                                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 text-sm text-slate-700 outline-none transition-all focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                                            placeholder="06 XX XX XX XX"
                                        >

                                    </div>

                                    @error('phone')
                                        <p class="mt-2 text-sm text-red-500">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>


                                {{-- Email --}}
                                <div>

                                    <label
                                        for="email"
                                        class="block text-sm font-semibold text-slate-700 mb-2"
                                    >
                                        Email
                                    </label>

                                    <div class="relative">

                                        <i
                                            data-lucide="mail"
                                            class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"
                                        ></i>

                                        <input
                                            type="email"
                                            id="email"
                                            name="email"
                                            value="{{ old('email', $client->email) }}"
                                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 text-sm text-slate-700 outline-none transition-all focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                                            placeholder="client@example.com"
                                        >

                                    </div>

                                    @error('email')
                                        <p class="mt-2 text-sm text-red-500">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>

                            </div>


                            {{-- Address --}}
                            <div>

                                <label
                                    for="address"
                                    class="block text-sm font-semibold text-slate-700 mb-2"
                                >
                                    Adresse
                                </label>

                                <div class="relative">

                                    <i
                                        data-lucide="map-pin"
                                        class="absolute left-3 top-4 w-4 h-4 text-slate-400"
                                    ></i>

                                    <textarea
                                        id="address"
                                        name="address"
                                        rows="4"
                                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 text-sm text-slate-700 outline-none transition-all focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 resize-none"
                                        placeholder="Adresse du client"
                                    >{{ old('address', $client->address) }}</textarea>

                                </div>

                                @error('address')
                                    <p class="mt-2 text-sm text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                        </div>


                        {{-- Footer --}}
                        <div class="px-6 py-5 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3">

                            <a
                                href="{{ route('clients.show', $client) }}"
                                class="px-5 py-2.5 bg-white border border-slate-200 rounded-xl text-slate-600 text-sm font-bold hover:bg-slate-50 transition-all"
                            >
                                Annuler
                            </a>

                            <button
                                type="submit"
                                class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all flex items-center gap-2"
                            >
                                <i data-lucide="save" class="w-4 h-4"></i>

                                Enregistrer les modifications
                            </button>

                        </div>

                    </form>

                </div>


                {{-- Client Summary --}}
                <div class="space-y-6">

                    {{-- Profile Card --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">

                        <div class="p-6 border-b border-slate-100">

                            <h2 class="text-lg font-bold text-slate-800">
                                Résumé du client
                            </h2>

                            <p class="text-sm text-slate-400 mt-1">
                                Informations actuelles
                            </p>

                        </div>


                        <div class="p-6">

                            {{-- Avatar --}}
                            <div class="flex flex-col items-center text-center pb-6 border-b border-slate-100">

                                <div class="w-20 h-20 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 text-2xl font-black mb-4">
                                    {{ $initials }}
                                </div>

                                <h3 class="text-lg font-bold text-slate-800">
                                    {{ $client->name }}
                                </h3>

                                <p class="text-sm text-slate-400 mt-1">
                                    Client depuis
                                    {{ $client->created_at->translatedFormat('F Y') }}
                                </p>

                            </div>


                            {{-- Contact --}}
                            <div class="py-6 space-y-5">

                                {{-- Phone --}}
                                <div class="flex items-start gap-3">

                                    <div class="w-9 h-9 rounded-lg bg-slate-50 flex items-center justify-center shrink-0">
                                        <i
                                            data-lucide="phone"
                                            class="w-4 h-4 text-slate-500"
                                        ></i>
                                    </div>

                                    <div class="min-w-0">

                                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                                            Téléphone
                                        </p>

                                        @if ($client->phone)

                                            <p class="text-sm font-semibold text-slate-700 mt-1 break-words">
                                                {{ $client->phone }}
                                            </p>

                                        @else

                                            <p class="text-sm text-slate-400 mt-1">
                                                Non renseigné
                                            </p>

                                        @endif

                                    </div>

                                </div>


                                {{-- Email --}}
                                <div class="flex items-start gap-3">

                                    <div class="w-9 h-9 rounded-lg bg-slate-50 flex items-center justify-center shrink-0">
                                        <i
                                            data-lucide="mail"
                                            class="w-4 h-4 text-slate-500"
                                        ></i>
                                    </div>

                                    <div class="min-w-0">

                                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                                            Email
                                        </p>

                                        @if ($client->email)

                                            <p class="text-sm font-semibold text-slate-700 mt-1 break-words">
                                                {{ $client->email }}
                                            </p>

                                        @else

                                            <p class="text-sm text-slate-400 mt-1">
                                                Non renseigné
                                            </p>

                                        @endif

                                    </div>

                                </div>


                                {{-- Address --}}
                                <div class="flex items-start gap-3">

                                    <div class="w-9 h-9 rounded-lg bg-slate-50 flex items-center justify-center shrink-0">
                                        <i
                                            data-lucide="map-pin"
                                            class="w-4 h-4 text-slate-500"
                                        ></i>
                                    </div>

                                    <div class="min-w-0">

                                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                                            Adresse
                                        </p>

                                        @if ($client->address)

                                            <p class="text-sm font-semibold text-slate-700 mt-1 break-words">
                                                {{ $client->address }}
                                            </p>

                                        @else

                                            <p class="text-sm text-slate-400 mt-1">
                                                Non renseignée
                                            </p>

                                        @endif

                                    </div>

                                </div>

                            </div>


                            {{-- Stats --}}
                            <div class="grid grid-cols-2 gap-3">

                                <div class="bg-slate-50 rounded-xl p-4">

                                    <div class="flex items-center gap-2 mb-2">

                                        <i
                                            data-lucide="shopping-bag"
                                            class="w-4 h-4 text-indigo-500"
                                        ></i>

                                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                                            Commandes
                                        </span>

                                    </div>

                                    <p class="text-xl font-black text-slate-800">
                                        {{ $client->orders->count() }}
                                    </p>

                                </div>


                                <div class="bg-slate-50 rounded-xl p-4">

                                    <div class="flex items-center gap-2 mb-2">

                                        <i
                                            data-lucide="wallet"
                                            class="w-4 h-4 text-emerald-500"
                                        ></i>

                                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                                            Total
                                        </span>

                                    </div>

                                    <p class="text-lg font-black text-slate-800">
                                        {{ number_format($client->orders->sum('total_amount'), 2, '.', ',') }}
                                        <span class="text-xs font-medium text-slate-400">
                                            DH
                                        </span>
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- Help Card --}}
                    <div class="bg-indigo-50 border border-indigo-100 rounded-2xl p-5">

                        <div class="flex items-start gap-3">

                            <div class="w-9 h-9 rounded-lg bg-indigo-100 flex items-center justify-center shrink-0">

                                <i
                                    data-lucide="info"
                                    class="w-4 h-4 text-indigo-600"
                                ></i>

                            </div>

                            <div>

                                <h3 class="text-sm font-bold text-indigo-900">
                                    Modification du client
                                </h3>

                                <p class="text-xs text-indigo-700/80 mt-1 leading-relaxed">
                                    Les modifications seront enregistrées immédiatement
                                    après validation du formulaire.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </main>

    </div>


    <script>
        lucide.createIcons();
    </script>

</x-layout>