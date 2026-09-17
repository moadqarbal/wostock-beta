<x-layout>
    <div class="lg:ml-72 min-h-screen flex flex-col transition-all duration-300">
        {{-- Topbar --}}
        <x-navigation.topbar />
        {{-- PAGE CONTENT --}}
        <main class="p-4 lg:p-8 flex-grow">
            {{-- Page Header --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                <div>
                    <div class="flex items-center gap-2 text-slate-500 text-sm mb-2">
                        <a href="{{ route('clients.index') }}"
                            class="hover:text-indigo-600 transition-colors text-xs font-medium">
                            Clients
                        </a>
                        <i data-lucide="chevron-right" class="w-3 h-3 text-slate-400"></i>
                        <span class="text-slate-900 font-medium text-xs">
                            Nouveau client
                        </span>
                    </div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Ajouter un Client
                    </h1>
                    <p class="text-slate-500 text-sm">
                        Créez une nouvelle fiche client et suivez ses activités.
                    </p>
                </div>
                {{-- Header Actions --}}
                <div class="flex items-center gap-3">
                    <a href="{{ route('clients.index') }}"
                        class="px-6 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-semibold text-sm hover:bg-slate-50 transition-all">
                        Annuler
                    </a>
                    <button type="submit" form="client-form"
                        class="px-6 py-2.5 rounded-xl bg-indigo-600 text-white font-semibold text-sm hover:bg-indigo-700 shadow-lg shadow-indigo-600/20 transition-all flex items-center gap-2">
                        <i data-lucide="user-plus" class="w-4 h-4"></i>
                        Enregistrer le client
                    </button>
                </div>
            </div>
            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4">
                    <div class="flex items-start gap-3">
                        <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 shrink-0 mt-0.5"></i>
                        <div>
                            <h3 class="font-semibold text-red-800 text-sm">
                                Veuillez corriger les erreurs suivantes :
                            </h3>
                            <ul class="mt-2 list-disc list-inside text-sm text-red-700 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>
                                        {{ $error }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            {{-- Form --}}
            <form id="client-form" action="{{ route('clients.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 gap-8">
                    {{-- Client Information --}}
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                            <i data-lucide="user" class="w-5 h-5 text-indigo-500"></i>
                            Profil du Client
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Name --}}
                            <div>
                                <label for="client-name" class="block text-sm font-semibold text-slate-700 mb-2">
                                    Nom Complet *
                                </label>
                                <input type="text" id="client-name" name="name" value="{{ old('name') }}"
                                    placeholder="Ex: Mohammed Alami" autofocus
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition-all bg-slate-50/30 @error('name') border-red-400 @enderror">
                                @error('name')
                                    <p class="mt-1.5 text-xs text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            {{-- Phone --}}
                            <div>
                                <label for="client-phone" class="block text-sm font-semibold text-slate-700 mb-2">
                                    Téléphone
                                </label>
                                <div class="relative">
                                    <i data-lucide="phone"
                                        class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                                    <input type="tel" id="client-phone" name="phone" value="{{ old('phone') }}"
                                        placeholder="+212 6..."
                                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition-all bg-slate-50/30 @error('phone') border-red-400 @enderror">
                                </div>
                                @error('phone')
                                    <p class="mt-1.5 text-xs text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            {{-- Email --}}
                            <div>
                                <label for="client-email" class="block text-sm font-semibold text-slate-700 mb-2">
                                    Email
                                </label>
                                <div class="relative">
                                    <i data-lucide="mail"
                                        class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                                    <input type="email" id="client-email" name="email" value="{{ old('email') }}"
                                        placeholder="Ex: client@email.com"
                                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition-all bg-slate-50/30 @error('email') border-red-400 @enderror">
                                </div>
                                @error('email')
                                    <p class="mt-1.5 text-xs text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            {{-- Address --}}
                            <div>
                                <label for="client-address" class="block text-sm font-semibold text-slate-700 mb-2">
                                    Adresse
                                </label>
                                <textarea id="client-address" name="address" rows="3" placeholder="N°, Rue, Quartier..."
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition-all bg-slate-50/30 resize-none @error('address') border-red-400 @enderror">{{ old('address') }}</textarea>
                                @error('address')
                                    <p class="mt-1.5 text-xs text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>


    {{-- Scripts --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>

</x-layout>
