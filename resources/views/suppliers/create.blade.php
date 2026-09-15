<x-layout>
    <div class="lg:ml-72 min-h-screen flex flex-col transition-all duration-300">

        <x-navigation.topbar />

        <main class="p-4 lg:p-8 flex-grow w-full">

            <!-- En-tête -->
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                <div>
                    <div class="flex items-center gap-2 text-slate-500 text-sm mb-2">
                        <a
                            href="{{ route('suppliers.index') }}"
                            class="hover:text-indigo-600 transition-colors text-xs font-medium"
                        >
                            Fournisseurs
                        </a>

                        <i data-lucide="chevron-right" class="w-3 h-3 text-slate-400"></i>

                        <span class="text-slate-900 font-medium text-xs">
                            Nouveau fournisseur
                        </span>
                    </div>

                    <h1 class="text-2xl font-bold text-slate-900">
                        Ajouter un Fournisseur
                    </h1>

                    <p class="text-slate-500 text-sm">
                        Enregistrez un nouveau partenaire commercial dans votre base de données WoStock.
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <a
                        href="{{ route('suppliers.index') }}"
                        class="px-6 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-semibold text-sm hover:bg-slate-50 transition-all"
                    >
                        Annuler
                    </a>

                    <button
                        type="submit"
                        form="supplier-form"
                        class="px-6 py-2.5 rounded-xl bg-indigo-600 text-white font-semibold text-sm hover:bg-indigo-700 shadow-lg shadow-indigo-600/20 transition-all flex items-center gap-2 text-center justify-center"
                    >
                        <i data-lucide="user-plus" class="w-4 h-4"></i>

                        <span class="hidden sm:inline">
                            Enregistrer le fournisseur
                        </span>

                        <span class="sm:hidden">
                            Enregistrer
                        </span>
                    </button>
                </div>
            </div>

            <!-- Formulaire -->
            <form
                id="supplier-form"
                action="{{ route('suppliers.store') }}"
                method="POST"
            >
                @csrf

                <div class="grid grid-cols-1 xl:grid-cols-4 gap-8">

                    <!-- Informations principales -->
                    <div class="xl:col-span-3 space-y-6">

                        <!-- Coordonnées principales -->
                        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
                            <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                                <i data-lucide="info" class="w-5 h-5 text-indigo-500"></i>
                                Coordonnées principales
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                <!-- Nom -->
                                <div class="md:col-span-2">
                                    <label
                                        for="company_name"
                                        class="block text-sm font-semibold text-slate-700 mb-2"
                                    >
                                        Nom de l'entreprise / Fournisseur *
                                    </label>

                                    <input
                                        type="text"
                                        id="company_name"
                                        name="company_name"
                                        value="{{ old('company_name') }}"
                                        placeholder="Ex: Sony Maroc SA"
                                        required
                                        class="w-full px-4 py-3.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition-all bg-slate-50/30 @error('company_name') border-red-500 @enderror"
                                    >

                                    @error('company_name')
                                        <p class="mt-1 text-sm text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Téléphone -->
                                <div>
                                    <label
                                        for="phone"
                                        class="block text-sm font-semibold text-slate-700 mb-2"
                                    >
                                        Téléphone direct *
                                    </label>

                                    <div class="relative">
                                        <i
                                            data-lucide="phone"
                                            class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"
                                        ></i>

                                        <input
                                            type="tel"
                                            id="phone"
                                            name="phone"
                                            value="{{ old('phone') }}"
                                            placeholder="+212 5..."
                                            required
                                            class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition-all bg-slate-50/30 @error('phone') border-red-500 @enderror"
                                        >
                                    </div>

                                    @error('phone')
                                        <p class="mt-1 text-sm text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label
                                        for="email"
                                        class="block text-sm font-semibold text-slate-700 mb-2"
                                    >
                                        E-mail professionnel
                                    </label>

                                    <div class="relative">
                                        <i
                                            data-lucide="mail"
                                            class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"
                                        ></i>

                                        <input
                                            type="email"
                                            id="email"
                                            name="email"
                                            value="{{ old('email') }}"
                                            placeholder="contact@fournisseur.ma"
                                            class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition-all bg-slate-50/30 @error('email') border-red-500 @enderror"
                                        >
                                    </div>

                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        <!-- Adresse & Localisation -->
                        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
                            <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                                <i data-lucide="map-pin" class="w-5 h-5 text-indigo-500"></i>
                                Adresse & Localisation
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                                <!-- Adresse -->
                                <div class="md:col-span-3">
                                    <label
                                        for="address"
                                        class="block text-sm font-semibold text-slate-700 mb-2"
                                    >
                                        Adresse du siège
                                    </label>

                                    <input
                                        type="text"
                                        id="address"
                                        name="address"
                                        value="{{ old('address') }}"
                                        placeholder="N°, Rue, Quartier..."
                                        class="w-full px-4 py-3.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition-all bg-slate-50/30 @error('address') border-red-500 @enderror"
                                    >

                                    @error('address')
                                        <p class="mt-1 text-sm text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Ville -->
                                <div>
                                    <label
                                        for="city"
                                        class="block text-sm font-semibold text-slate-700 mb-2"
                                    >
                                        Ville
                                    </label>

                                    <input
                                        type="text"
                                        id="city"
                                        name="city"
                                        value="{{ old('city') }}"
                                        placeholder="Ex: Casablanca"
                                        class="w-full px-4 py-3.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition-all bg-slate-50/30 @error('city') border-red-500 @enderror"
                                    >

                                    @error('city')
                                        <p class="mt-1 text-sm text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Code postal -->
                                <div>
                                    <label
                                        for="postal_code"
                                        class="block text-sm font-semibold text-slate-700 mb-2"
                                    >
                                        Code Postal
                                    </label>

                                    <input
                                        type="text"
                                        id="postal_code"
                                        name="postal_code"
                                        value="{{ old('postal_code') }}"
                                        placeholder="Ex: 20000"
                                        class="w-full px-4 py-3.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition-all bg-slate-50/30 @error('postal_code') border-red-500 @enderror"
                                    >

                                    @error('postal_code')
                                        <p class="mt-1 text-sm text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Pays -->
                                <div>
                                    <label
                                        for="country"
                                        class="block text-sm font-semibold text-slate-700 mb-2"
                                    >
                                        Pays
                                    </label>

                                    <select
                                        id="country"
                                        name="country"
                                        class="w-full px-4 py-3.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition-all bg-slate-50/30 appearance-none @error('country') border-red-500 @enderror"
                                    >
                                        <option value="Maroc" @selected(old('country', 'Maroc') === 'Maroc')>
                                            Maroc
                                        </option>

                                        <option value="France" @selected(old('country') === 'France')>
                                            France
                                        </option>

                                        <option value="Espagne" @selected(old('country') === 'Espagne')>
                                            Espagne
                                        </option>
                                    </select>

                                    @error('country')
                                        <p class="mt-1 text-sm text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                            </div>
                        </div>

                    </div>

                    <!-- Notes -->
                    <div class="space-y-6">
                        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 h-full flex flex-col">

                            <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                                <i data-lucide="sticky-note" class="w-4 h-4 text-indigo-500"></i>
                                Notes confidentielles
                            </h3>

                            <textarea
                                id="notes"
                                name="notes"
                                placeholder="Ajoutez des détails sur la fiabilité, les délais habituels ou les conditions de paiement..."
                                class="w-full flex-grow px-4 py-4 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition-all bg-slate-50/30 text-sm min-h-[300px] @error('notes') border-red-500 @enderror"
                            >{{ old('notes') }}</textarea>

                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                            <div class="mt-6 p-4 bg-amber-50 rounded-xl border border-amber-100">
                                <p class="text-[11px] text-amber-700 font-medium leading-relaxed">
                                    <i data-lucide="alert-circle" class="w-3 h-3 inline mr-1"></i>
                                    Ces notes ne sont jamais partagées avec le fournisseur.
                                </p>
                            </div>

                        </div>
                    </div>

                </div>
            </form>

        </main>

        <x-ui.success />
        <x-ui.error />

    </div>
</x-layout>

<script>
    lucide.createIcons();
</script>