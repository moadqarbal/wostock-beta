<x-layout>
    <!-- MAIN CONTENT -->
    <div class="lg:ml-72 min-h-screen flex flex-col transition-all duration-300">

        <!-- NAVBAR -->
        <x-navigation.topbar />

        <!-- PAGE CONTENT -->
        <!-- PAGE CONTENT -->
        <main class="p-4 lg:p-8 flex-grow w-full">

            <!-- En-tête -->
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase">Paramètres</h1>
                    <p class="text-slate-500 font-medium">Gérez votre compte et boostez votre croissance.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-10">

                <!-- COLONNE GAUCHE : Profil & Sécurité (2/3) -->
                <div class="xl:col-span-2 space-y-8">

                    <!-- Section 1 : Profil -->
                    <form action="{{ route('dashboard.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm">
                            <h3
                                class="text-lg font-black text-slate-800 uppercase tracking-widest mb-8 flex items-center gap-3">
                                <div class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl">
                                    <i data-lucide="user" class="w-5 h-5"></i>
                                </div>
                                Mon Profil
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                                <div>
                                    <label
                                        class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">
                                        Nom d'utilisateur
                                    </label>

                                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                                        class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition-all bg-slate-50/50 text-lg font-bold text-slate-800">

                                    @error('name')
                                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label
                                        class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">
                                        Adresse E-mail
                                    </label>

                                    <input type="email" name="email"
                                        value="{{ old('email', auth()->user()->email) }}"
                                        class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition-all bg-slate-50/50 text-lg font-bold text-slate-800">

                                    @error('email')
                                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>

                            <button type="submit"
                                class="mt-8 px-8 py-3 rounded-2xl bg-indigo-600 text-white font-black text-xs uppercase tracking-widest hover:bg-indigo-700 shadow-xl shadow-indigo-200 transition-all">
                                Enregistrer
                            </button>
                        </div>
                    </form>


                    <!-- Section 2 : Sécurité -->
                    <form action="{{ route('dashboard.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm">

                            <h3
                                class="text-lg font-black text-slate-800 uppercase tracking-widest mb-8 flex items-center gap-3">
                                <div class="p-2.5 bg-red-50 text-red-600 rounded-xl">
                                    <i data-lucide="lock" class="w-5 h-5"></i>
                                </div>
                                Sécurité
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                                <div>
                                    <label
                                        class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">
                                        Mot de passe actuel
                                    </label>

                                    <input type="password" name="current_password" placeholder="••••••••"
                                        class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition-all bg-slate-50/50">

                                    @error('current_password')
                                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label
                                        class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">
                                        Nouveau mot de passe
                                    </label>

                                    <input type="password" name="password" placeholder="••••••••"
                                        class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition-all bg-slate-50/50">

                                    @error('password')
                                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label
                                        class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">
                                        Confirmer
                                    </label>

                                    <input type="password" name="password_confirmation" placeholder="••••••••"
                                        class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition-all bg-slate-50/50">
                                </div>

                            </div>

                            <button type="submit"
                                class="mt-8 px-8 py-3 rounded-2xl bg-red-600 text-white font-black text-xs uppercase tracking-widest hover:bg-red-700 transition-all">
                                Modifier le mot de passe
                            </button>

                        </div>
                    </form>


                    <!-- Section 3 : Feedback & Help (Bento) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Proposer Feature -->
                        <div class="bg-slate-900 p-8 rounded-[2rem] text-white flex flex-col justify-between group">

                            <div>
                                <div
                                    class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                                    <i data-lucide="lightbulb" class="w-6 h-6 text-yellow-400"></i>
                                </div>

                                <h3 class="text-xl font-black mb-3">Une idée ?</h3>

                                <p class="text-slate-400 text-sm leading-relaxed">
                                    Vous souhaitez proposer une nouvelle fonctionnalité pour WoStock ?
                                </p>
                            </div>

                            <a href="mailto:wobranding1@gmail.com?subject=Feature Proposal - WoStock"
                                class="mt-8 inline-flex items-center justify-center gap-3 px-6 py-3.5 bg-white text-slate-900 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-indigo-500 hover:text-white transition-all">
                                Proposer une feature
                            </a>

                        </div>


                        <!-- Support -->
                        <div
                            class="bg-indigo-600 p-8 rounded-[2rem] text-white flex flex-col justify-between shadow-xl shadow-indigo-200">

                            <div>
                                <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center mb-6">
                                    <i data-lucide="help-circle" class="w-6 h-6"></i>
                                </div>

                                <h3 class="text-xl font-black mb-3">Besoin d'aide ?</h3>

                                <p class="text-indigo-100 text-sm leading-relaxed">
                                    Notre équipe technique est à votre disposition 24/7.
                                </p>
                            </div>

                            <div class="mt-8 p-4 bg-white/10 rounded-2xl border border-white/10 text-center">
                                <span class="text-sm font-black tracking-tight">
                                    wobranding1@gmail.com
                                </span>
                            </div>

                        </div>

                    </div>

                </div>


                <!-- COLONNE DROITE : ADS CONSULTANT (S'affiche en premier sur Mobile) -->
                <div class="space-y-8">

                    <!-- CARTE MOAD KHERBAL - ATTENTION CATCHER -->
                    <div class="bg-slate-950 rounded-[3rem] p-10 text-white relative overflow-hidden shadow-2xl">

                        <!-- Glow effect خلفية -->
                        <div class="absolute -top-20 -right-20 w-64 h-64 bg-indigo-600/30 blur-[100px] rounded-full">
                        </div>
                        <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-emerald-600/20 blur-[100px] rounded-full">
                        </div>

                        <div class="relative z-10">

                            <div class="mb-8 flex justify-center">
                                <div class="relative">

                                    <div
                                        class="w-24 h-24 bg-gradient-to-tr from-indigo-600 to-purple-500 rounded-[2rem] flex items-center justify-center shadow-2xl animate-pulse">
                                        <i data-lucide="trending-up" class="w-12 h-12 text-white"></i>
                                    </div>

                                    <span
                                        class="absolute -top-2 -right-2 bg-emerald-500 text-[10px] font-black px-3 py-1 rounded-full border-4 border-slate-950 uppercase tracking-tighter">
                                        Live Now
                                    </span>

                                </div>
                            </div>


                            <h2 class="text-3xl font-black text-center leading-[1.1] mb-6">
                                طلع لبيزنس ديالك <br>
                                <span
                                    class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-emerald-400 italic">
                                    بإعلانات احترافية
                                </span>
                            </h2>


                            <div class="space-y-6 mb-10 text-right" dir="rtl">

                                <p class="text-lg leading-relaxed text-slate-200">
                                    سميتي
                                    <span class="text-indigo-400 font-black underline decoration-2 underline-offset-4">
                                        معاذ قربال
                                    </span>،
                                    خبير في الاستشارة الإعلانية وتطوير المواقع.
                                </p>

                                <div class="bg-white/5 border-l-4 border-indigo-500 p-5 rounded-2xl">
                                    <p class="text-sm text-slate-300 leading-relaxed font-medium">
                                        كنعاون الشركات باش يكبرو عن طريق الأدس و التسويق الذكي، صفحات هبوط المواقع الويب
                                        لي كتجيب المبيعات، وحلول ويب كتركز على النتائج.
                                    </p>
                                </div>

                                <div class="bg-emerald-500/10 border border-emerald-500/20 p-5 rounded-2xl text-center">
                                    <h4 class="text-emerald-400 font-black text-sm uppercase mb-1">
                                        استشارة مجانية (15 دقيقة)
                                    </h4>

                                    <p class="text-[11px] text-emerald-500/70 font-bold uppercase tracking-widest">
                                        Double or Triple your sales
                                    </p>
                                </div>

                            </div>


                            <!-- CTA BUTTONS -->
                            <div class="space-y-4">

                                <a href="https://api.whatsapp.com/send?phone=212605218908&text=Hello%20Moad,%20je%20souhaite%20une%20consultation%20gratuite"
                                    target="_blank"
                                    class="group flex items-center justify-center gap-4 w-full py-5 bg-emerald-500 text-white rounded-[1.5rem] font-black text-sm uppercase tracking-[0.15em] hover:bg-emerald-400 transition-all shadow-xl shadow-emerald-500/20 active:scale-95">
                                    <i data-lucide="message-circle"
                                        class="w-6 h-6 group-hover:rotate-12 transition-transform"></i>
                                    ابدأ الآن
                                </a>

                                <a href="https://wobranding.com/" target="_blank"
                                    class="flex items-center justify-center gap-4 w-full py-5 bg-white/5 text-white rounded-[1.5rem] font-black text-sm uppercase tracking-[0.15em] border border-white/10 hover:bg-white/10 transition-all">
                                    <i data-lucide="globe" class="w-5 h-5"></i>
                                    Visiter mon site
                                </a>

                            </div>

                        </div>

                    </div>


                    <!-- Citation Box -->
                    <div
                        class="bg-white p-8 rounded-[2.5rem] border border-slate-100 text-center shadow-sm relative group overflow-hidden">

                        <div
                            class="absolute inset-0 bg-indigo-50 opacity-0 group-hover:opacity-100 transition-opacity">
                        </div>

                        <i data-lucide="quote" class="w-8 h-8 text-indigo-100 mx-auto mb-4 relative"></i>

                        <p class="text-slate-600 font-bold text-lg leading-relaxed relative" dir="rtl">
                            “الشغف هو اللي كيصنع البزنس، ولكن البزنس ما يقدرش يصنع الشغف”
                        </p>

                        <p class="text-[10px] font-black text-slate-300 mt-4 uppercase tracking-[0.3em] relative">
                            Created by Moad - 2026
                        </p>

                    </div>

                </div>

            </div>
        </main>

        <script>
            lucide.createIcons();
        </script>
    </div>
</x-layout>
