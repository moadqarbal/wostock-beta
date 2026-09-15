<x-layout>
    <div class="lg:ml-72 min-h-screen flex flex-col transition-all duration-300">
        <x-navigation.topbar />
        <main class="p-4 lg:p-8 flex-grow">
            {{-- Header --}}
            <div class="mb-8">
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
                    <a
                        href="{{ route('categories.index') }}"
                        class="hover:text-indigo-600 text-xs font-medium"
                    >
                        Catégories
                    </a>
                    <i
                        data-lucide="chevron-right"
                        class="w-3 h-3 text-slate-400"
                    ></i>
                    <span class="text-slate-900 font-medium text-xs">
                        Nouvelle catégorie
                    </span>
                </div>
                <h1 class="text-2xl font-bold text-slate-900">
                    Nouvelle catégorie
                </h1>
                <p class="text-slate-500 text-sm">
                    Ajoutez une nouvelle catégorie à votre inventaire.
                </p>
            </div>
            {{-- Form --}}
            <div class="w-full">
                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                    <form
                        action="{{ route('categories.store') }}"
                        method="POST"
                    >
                        @csrf
                        <div class="p-6 lg:p-8 space-y-6">
                            {{-- Name --}}
                            <div>
                                <label
                                    for="name"
                                    class="block text-sm font-semibold text-slate-700 mb-2"
                                >
                                    Nom de la catégorie
                                </label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="Ex: Informatique"
                                    class="w-full px-4 py-3.5 rounded-xl border border-slate-200 bg-white text-slate-900 placeholder-slate-400 outline-none focus:border-indigo-500"
                                    required
                                >
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            {{-- Description --}}
                            <div>
                                <label
                                    for="description"
                                    class="block text-sm font-semibold text-slate-700 mb-2"
                                >
                                    Description
                                </label>
                                <textarea
                                    id="description"
                                    name="description"
                                    rows="5"
                                    placeholder="Description courte de la catégorie..."
                                    class="w-full px-4 py-3.5 rounded-xl border border-slate-200 bg-white text-slate-900 placeholder-slate-400 outline-none focus:border-indigo-500"
                                >{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-2 text-sm text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                        {{-- Footer --}}
                        <div class="px-6 lg:px-8 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3">
                            <a
                                href="{{ route('categories.index') }}"
                                class="px-5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-600 text-sm font-semibold hover:bg-slate-50"
                            >
                                Annuler
                            </a>
                            <button
                                type="submit"
                                class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700"
                            >
                                Ajouter la catégorie
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
    <x-ui.success />
    <x-ui.error />
</x-layout>