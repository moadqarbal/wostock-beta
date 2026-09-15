<x-layout>
    <div class="lg:ml-72 min-h-screen flex flex-col transition-all duration-300">
        <x-navigation.topbar />
        <main class="flex-1 bg-slate-50 p-6 lg:p-8">
            {{-- Header --}}
            <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between mb-8">
                <div>
                    <div class="flex items-center gap-2 text-sm text-slate-500 mb-2">
                        <a
                            href="{{ route('suppliers.index') }}"
                            class="hover:text-indigo-600"
                        >
                            Fournisseurs
                        </a>
                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                        <a
                            href="{{ route('suppliers.show', $supplier) }}"
                            class="hover:text-indigo-600"
                        >
                            {{ $supplier->company_name }}
                        </a>
                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                        <span class="text-slate-800">
                            Modifier
                        </span>
                    </div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Modifier le fournisseur
                    </h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Modifiez les informations de ce fournisseur.
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a
                        href="{{ route('suppliers.show', $supplier) }}"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm font-medium text-slate-700 hover:bg-slate-50"
                    >
                        <i data-lucide="x" class="w-4 h-4"></i>
                        Annuler
                    </a>
                    <button
                        type="submit"
                        form="supplier-form"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700"
                    >
                        <i data-lucide="save" class="w-4 h-4"></i>
                        Enregistrer les modifications
                    </button>
                </div>
            </div>
            {{-- Form --}}
            <form
                id="supplier-form"
                action="{{ route('suppliers.update', $supplier) }}"
                method="POST"
                class="space-y-6"
            >
                @csrf
                @method('PUT')
                {{-- Informations générales --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">
                    <div class="px-6 py-5 border-b border-slate-100">
                        <h2 class="text-base font-bold text-slate-900">
                            Informations générales
                        </h2>
                        <p class="mt-1 text-sm text-slate-500">
                            Informations principales du fournisseur.
                        </p>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Company --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Nom de l'entreprise
                                <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                name="company_name"
                                value="{{ old('company_name', $supplier->company_name) }}"
                                placeholder="Ex: ABC Distribution"
                                class="w-full px-4 py-3.5 rounded-xl border border-slate-200 bg-white text-slate-900 placeholder-slate-400 outline-none focus:border-indigo-500"
                            >
                            @error('company_name')
                                <p class="mt-1.5 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        {{-- Phone --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Téléphone
                                <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                name="phone"
                                value="{{ old('phone', $supplier->phone) }}"
                                placeholder="Ex: 06 00 00 00 00"
                                class="w-full px-4 py-3.5 rounded-xl border border-slate-200 bg-white text-slate-900 placeholder-slate-400 outline-none focus:border-indigo-500"
                            >
                            @error('phone')
                                <p class="mt-1.5 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        {{-- Email --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Email
                            </label>
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email', $supplier->email) }}"
                                placeholder="Ex: contact@entreprise.com"
                                class="w-full px-4 py-3.5 rounded-xl border border-slate-200 bg-white text-slate-900 placeholder-slate-400 outline-none focus:border-indigo-500"
                            >
                            @error('email')
                                <p class="mt-1.5 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        {{-- Country --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Pays
                                <span class="text-red-500">*</span>
                            </label>
                            <select
                                name="country"
                                class="w-full px-4 py-3.5 rounded-xl border border-slate-200 bg-white text-slate-900 outline-none focus:border-indigo-500"
                            >
                                <option value="Maroc" @selected(old('country', $supplier->country) === 'Maroc')>
                                    Maroc
                                </option>
                                <option value="France" @selected(old('country', $supplier->country) === 'France')>
                                    France
                                </option>
                                <option value="Espagne" @selected(old('country', $supplier->country) === 'Espagne')>
                                    Espagne
                                </option>
                            </select>
                            @error('country')
                                <p class="mt-1.5 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>
                {{-- Adresse --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">
                    <div class="px-6 py-5 border-b border-slate-100">
                        <h2 class="text-base font-bold text-slate-900">
                            Adresse & Localisation
                        </h2>
                        <p class="mt-1 text-sm text-slate-500">
                            Adresse et informations géographiques du fournisseur.
                        </p>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Address --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Adresse
                            </label>
                            <textarea
                                name="address"
                                rows="3"
                                placeholder="Adresse complète..."
                                class="w-full px-4 py-3.5 rounded-xl border border-slate-200 bg-white text-slate-900 placeholder-slate-400 outline-none focus:border-indigo-500"
                            >{{ old('address', $supplier->address) }}</textarea>
                            @error('address')
                                <p class="mt-1.5 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        {{-- City --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Ville
                            </label>
                            <input
                                type="text"
                                name="city"
                                value="{{ old('city', $supplier->city) }}"
                                placeholder="Ex: Casablanca"
                                class="w-full px-4 py-3.5 rounded-xl border border-slate-200 bg-white text-slate-900 placeholder-slate-400 outline-none focus:border-indigo-500"
                            >
                            @error('city')
                                <p class="mt-1.5 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        {{-- Postal code --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Code postal
                            </label>
                            <input
                                type="text"
                                name="postal_code"
                                value="{{ old('postal_code', $supplier->postal_code) }}"
                                placeholder="Ex: 20000"
                                class="w-full px-4 py-3.5 rounded-xl border border-slate-200 bg-white text-slate-900 placeholder-slate-400 outline-none focus:border-indigo-500"
                            >
                            @error('postal_code')
                                <p class="mt-1.5 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>
                {{-- Notes --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">
                    <div class="px-6 py-5 border-b border-slate-100">
                        <h2 class="text-base font-bold text-slate-900">
                            Notes
                        </h2>
                        <p class="mt-1 text-sm text-slate-500">
                            Ajoutez des informations complémentaires.
                        </p>
                    </div>
                    <div class="p-6">
                        <textarea
                            name="notes"
                            rows="5"
                            placeholder="Notes concernant ce fournisseur..."
                            class="w-full px-4 py-3.5 rounded-xl border border-slate-200 bg-white text-slate-900 placeholder-slate-400 outline-none focus:border-indigo-500"
                        >{{ old('notes', $supplier->notes) }}</textarea>
                        @error('notes')
                            <p class="mt-1.5 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </form>
        </main>
    </div>
    <x-ui.success />
    <x-ui.error />
    <script>
        lucide.createIcons();
    </script>
</x-layout>