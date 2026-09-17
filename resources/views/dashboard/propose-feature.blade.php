<x-layout>
    <div class="lg:ml-72 min-h-screen flex flex-col transition-all duration-300 bg-[#F8FAFC] overflow-x-hidden">

        <x-navigation.topbar />

        <main class="p-4 lg:p-8 flex-grow w-full">

            <!-- En-tête -->
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 gap-4">
                <div>
                    <div class="flex items-center gap-2 text-slate-500 text-[10px] uppercase font-black tracking-[0.2em] mb-2">
                        <span>Communauté</span>
                        <i data-lucide="chevron-right" class="w-3 h-3"></i>
                        <span class="text-indigo-600">Feature</span>
                    </div>

                    <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">
                        Construisons WoStock ensemble
                    </h1>

                    <p class="text-slate-500 font-medium mt-1">
                        Vous avez une idée pour améliorer l'outil ? Proposez une nouvelle fonctionnalité.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">

                <!-- WhatsApp -->
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-emerald-500/10 transition-all group">

                    <div class="w-14 h-14 bg-emerald-50 text-emerald-500 rounded-2xl flex items-center justify-center mb-8 group-hover:scale-110 transition-transform">
                        <i data-lucide="message-circle" class="w-7 h-7"></i>
                    </div>

                    <h3 class="text-xl font-black text-slate-800 mb-3">
                        Feedback Rapide
                    </h3>

                    <p class="text-slate-500 text-sm leading-relaxed mb-8">
                        Idéal pour les idées rapides ou les petites suggestions en direct.
                    </p>

                    <a
                        href="https://api.whatsapp.com/send?phone=212605218908&text=Hello%20Moad,%20j'ai%20une%20suggestion%20pour%20la%20prochaine%20version%20de%20WoStock%20:"
                        target="_blank"
                        class="flex items-center justify-center gap-3 w-full py-4 bg-emerald-500 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-emerald-600 transition-all shadow-lg shadow-emerald-500/20">

                        Discuter sur WhatsApp
                    </a>

                </div>


                <!-- Email / Feature Proposal -->
                <div class="bg-slate-900 p-8 rounded-[2.5rem] text-white shadow-sm relative overflow-hidden group">

                    <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/10 blur-[50px]"></div>

                    <div class="relative z-10">

                        <div class="w-14 h-14 bg-white/10 text-indigo-400 rounded-2xl flex items-center justify-center mb-8 group-hover:rotate-12 transition-transform">
                            <i data-lucide="mail" class="w-7 h-7"></i>
                        </div>

                        <h3 class="text-xl font-black mb-3">
                            Dossier de Feature
                        </h3>

                        <p class="text-slate-400 text-sm leading-relaxed mb-8">
                            Envoyez-nous une description complète de votre idée et expliquez-nous son utilité.
                        </p>


                        <!-- Success -->
                        @if (session('success'))
                            <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl text-emerald-400 text-sm font-bold">
                                {{ session('success') }}
                            </div>
                        @endif


                        <!-- Error -->
                        @if (session('error'))
                            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-2xl text-red-400 text-sm font-bold">
                                {{ session('error') }}
                            </div>
                        @endif


                        <!-- Validation errors -->
                        @if ($errors->any())
                            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-2xl text-red-400 text-sm font-bold">
                                {{ $errors->first() }}
                            </div>
                        @endif


                        <form
                            action="{{ route('dashboard.propose-feature.send') }}"
                            method="POST"
                            class="space-y-5">

                            @csrf

                            <!-- Sujet -->
                            <div>

                                <label class="block text-[10px] font-black text-slate-300 uppercase tracking-widest mb-2">
                                    Sujet
                                </label>

                                <input
                                    type="text"
                                    name="subject"
                                    value="{{ old('subject') }}"
                                    placeholder="Ex: Gestion des stocks par fournisseur"
                                    required
                                    class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 transition-all">

                            </div>


                            <!-- Description -->
                            <div>

                                <label class="block text-[10px] font-black text-slate-300 uppercase tracking-widest mb-2">
                                    Description
                                </label>

                                <textarea
                                    name="message"
                                    rows="6"
                                    placeholder="Décrivez votre idée, le problème qu'elle résout et comment vous imaginez son fonctionnement..."
                                    required
                                    class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 transition-all resize-none">{{ old('message') }}</textarea>

                            </div>


                            <!-- Submit -->
                            <button
                                type="submit"
                                class="flex items-center justify-center gap-3 w-full py-4 bg-indigo-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-indigo-500 transition-all shadow-lg shadow-indigo-500/20">

                                <i data-lucide="send" class="w-4 h-4"></i>

                                Envoyer la proposition

                            </button>

                        </form>

                    </div>

                </div>


                <!-- LinkedIn -->
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-blue-500/10 transition-all group">

                    <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-8 group-hover:scale-110 transition-transform">
                        <i data-lucide="linkedin" class="w-7 h-7"></i>
                    </div>

                    <h3 class="text-xl font-black text-slate-800 mb-3">
                        Réseau Professionnel
                    </h3>

                    <p class="text-slate-500 text-sm leading-relaxed mb-8">
                        Connectons-nous sur LinkedIn pour discuter de l'avenir du produit.
                    </p>

                    <a
                        href="https://www.linkedin.com/in/moad-qarbal/"
                        target="_blank"
                        class="flex items-center justify-center gap-3 w-full py-4 bg-blue-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/20">

                        Me contacter sur LinkedIn

                    </a>

                </div>

            </div>


            <!-- Footer Signature -->
            <div class="mt-16 p-10 bg-indigo-50 rounded-[3rem] border border-indigo-100 flex flex-col items-center text-center">

                <div class="w-20 h-20 bg-white rounded-[2rem] shadow-sm flex items-center justify-center mb-6">
                    <i data-lucide="lightbulb" class="w-10 h-10 text-indigo-600 animate-pulse"></i>
                </div>

                <h4 class="text-xl font-black text-indigo-900 mb-2">
                    Chaque idée compte.
                </h4>

                <p class="text-indigo-600/70 text-sm max-w-md font-medium">
                    WoStock est en version beta. Votre retour d'expérience est le moteur qui nous permet de créer l'outil parfait pour votre business.
                </p>

                <div class="mt-8 flex items-center gap-2">
                    <span class="text-[10px] font-black text-indigo-300 uppercase tracking-[0.4em]">
                        Developed by Moad @ WoBranding
                    </span>
                </div>

            </div>

        </main>

    </div>

    <script>
        lucide.createIcons();
    </script>
</x-layout>