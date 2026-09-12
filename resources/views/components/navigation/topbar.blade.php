<header
    class="h-20 bg-white/80 backdrop-blur-md border-b flex items-center justify-between px-4 lg:px-8 sticky top-0 z-30">
    <!-- Côté Gauche : Menu Mobile & Recherche -->
    <div class="flex items-center gap-4">
        <button onclick="toggleSidebar()" class="lg:hidden p-2 hover:bg-slate-100 rounded-lg transition-colors">
            <i data-lucide="menu" class="w-6 h-6"></i>
        </button>
        <div class="relative hidden md:block">
            <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
            <input type="text" placeholder="Rechercher..."
                class="pl-10 pr-4 py-2.5 bg-slate-100 border-none rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 w-72 transition-all">
        </div>
    </div>

    <!-- Côté Droit : Aide, Feature & Profil -->
    <div class="flex items-center gap-2">
        <!-- Icône Aide -->
        <a href="/settings/help.php" title="Besoin d'aide ?"
            class="p-2.5 text-slate-500 hover:bg-slate-100 rounded-xl transition-colors">
            <i data-lucide="help-circle" class="w-5 h-5"></i>
        </a>

        <!-- Icône Proposer une Feature -->
        <a href="/settings/propose-feature.php" title="Proposer une fonctionnalité"
            class="p-2.5 text-slate-500 hover:bg-slate-100 rounded-xl transition-colors">
            <i data-lucide="lightbulb" class="w-5 h-5 text-amber-500"></i>
        </a>

        <div class="h-8 w-px bg-slate-200 mx-2"></div>

        <!-- Profil Utilisateur -->
        <div class="relative">
            <button onclick="toggleUserMenu()"
                class="flex items-center gap-3 p-1.5 hover:bg-slate-50 rounded-xl transition-all">
                <img src="https://ui-avatars.com/api/?name=Admin+Wostock&background=6366f1&color=fff" alt="Avatar"
                    class="w-10 h-10 rounded-lg shadow-sm">
                <div class="text-left hidden sm:block">
                    <p class="text-sm font-bold text-slate-800">Admin WoStock</p>
                    <p class="text-[11px] text-slate-500 font-medium">{{ Auth::user()->name }}</p>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 ml-1"></i>
            </button>

            <!-- Dropdown Profil -->
            <div id="userMenu"
                class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 hidden animate-in fade-in zoom-in duration-200">
                <a href="/settings/my-profile.php"
                    class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                    <i data-lucide="user" class="w-4 h-4"></i> Mon Profil
                </a>
                <hr class="my-2 border-slate-100">

                <form action="{{ route('users.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors font-semibold">
                        <i data-lucide="log-out" class="w-4 h-4"></i> Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
