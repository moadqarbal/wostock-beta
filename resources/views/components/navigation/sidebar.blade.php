<aside id="sidebar"
    class="fixed inset-y-0 left-0 w-72 bg-slate-900 text-white transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-50 flex flex-col">

    <!-- Logo -->
    <div class="flex items-center justify-between h-20 px-6 bg-slate-950">

        <span class="text-2xl font-black tracking-tighter flex items-center gap-2">
            <i data-lucide="package" class="text-indigo-500"></i>

            WoStock

            <span class="text-xs font-medium bg-indigo-600 px-1.5 py-0.5 rounded text-white ml-1 uppercase">
                beta
            </span>
        </span>

        <button onclick="toggleSidebar()" class="lg:hidden">
            <i data-lucide="x" class="w-6 h-6"></i>
        </button>

    </div>


    <!-- Navigation -->
    <nav class="flex-grow mt-4 px-4 space-y-1 overflow-y-auto custom-scrollbar">


        {{-- Dashboard --}}
        <a href="{{ route('dashboard.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all
            {{ request()->routeIs('dashboard.index')
                ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/20'
                : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">

            <i data-lucide="layout-dashboard" class="w-5 h-5"></i>

            <span class="font-medium">
                Tableau de bord
            </span>

        </a>


        {{-- Analytics --}}
        <a href="{{ route('dashboard.analytics') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all
            {{ request()->routeIs('dashboard.analytics')
                ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/20'
                : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">

            <i data-lucide="line-chart" class="w-5 h-5"></i>

            <span class="font-medium">
                Analytiques
            </span>

        </a>


        <!-- ==================== PRODUITS ==================== -->

        <div class="space-y-1">

            <button
                onclick="toggleSubmenu('menu-produits', 'icon-produits')"
                class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all
                {{ request()->routeIs('products.*', 'categories.*')
                    ? 'bg-slate-800 text-white'
                    : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">

                <div class="flex items-center gap-3">

                    <i data-lucide="box" class="w-5 h-5"></i>

                    <span class="font-medium">
                        Produits
                    </span>

                </div>

                <i data-lucide="chevron-down"
                    id="icon-produits"
                    class="w-4 h-4 rotate-icon">
                </i>

            </button>


            <div id="menu-produits"
                class="submenu pl-10 space-y-1
                {{ request()->routeIs('products.*', 'categories.*') ? 'open' : '' }}">

                <a href="{{ route('products.index') }}"
                    class="block py-2 text-sm transition-all
                    {{ request()->routeIs('products.index')
                        ? 'text-indigo-400 font-semibold'
                        : 'text-slate-400 hover:text-indigo-400' }}">

                    Liste des produits

                </a>


                <a href="{{ route('products.create') }}"
                    class="block py-2 text-sm transition-all
                    {{ request()->routeIs('products.create')
                        ? 'text-indigo-400 font-semibold'
                        : 'text-slate-400 hover:text-indigo-400' }}">

                    Ajouter un produit

                </a>


                <a href="{{ route('categories.index') }}"
                    class="block py-2 text-sm transition-all
                    {{ request()->routeIs('categories.*')
                        ? 'text-indigo-400 font-semibold'
                        : 'text-slate-400 hover:text-indigo-400' }}">

                    Catégories

                </a>

            </div>

        </div>


        <!-- ==================== FOURNISSEURS ==================== -->

        <div class="space-y-1">

            <button
                onclick="toggleSubmenu('menu-fourn', 'icon-fourn')"
                class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all
                {{ request()->routeIs('suppliers.*')
                    ? 'bg-slate-800 text-white'
                    : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">

                <div class="flex items-center gap-3">

                    <i data-lucide="truck" class="w-5 h-5"></i>

                    <span class="font-medium">
                        Fournisseurs
                    </span>

                </div>

                <i data-lucide="chevron-down"
                    id="icon-fourn"
                    class="w-4 h-4 rotate-icon">
                </i>

            </button>


            <div id="menu-fourn"
                class="submenu pl-10 space-y-1
                {{ request()->routeIs('suppliers.*') ? 'open' : '' }}">

                <a href="{{ route('suppliers.index') }}"
                    class="block py-2 text-sm transition-all
                    {{ request()->routeIs('suppliers.index')
                        ? 'text-indigo-400 font-semibold'
                        : 'text-slate-400 hover:text-indigo-400' }}">

                    Liste fournisseurs

                </a>


                <a href="{{ route('suppliers.create') }}"
                    class="block py-2 text-sm transition-all
                    {{ request()->routeIs('suppliers.create')
                        ? 'text-indigo-400 font-semibold'
                        : 'text-slate-400 hover:text-indigo-400' }}">

                    Ajouter fournisseur

                </a>

            </div>

        </div>


        <!-- ==================== CLIENTS ==================== -->

        <div class="space-y-1">

            <button
                onclick="toggleSubmenu('menu-clients', 'icon-clients')"
                class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all
                {{ request()->routeIs('clients.*')
                    ? 'bg-slate-800 text-white'
                    : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">

                <div class="flex items-center gap-3">

                    <i data-lucide="users" class="w-5 h-5"></i>

                    <span class="font-medium">
                        Clients
                    </span>

                </div>

                <i data-lucide="chevron-down"
                    id="icon-clients"
                    class="w-4 h-4 rotate-icon">
                </i>

            </button>


            <div id="menu-clients"
                class="submenu pl-10 space-y-1
                {{ request()->routeIs('clients.*') ? 'open' : '' }}">

                <a href="{{ route('clients.index') }}"
                    class="block py-2 text-sm transition-all
                    {{ request()->routeIs('clients.index')
                        ? 'text-indigo-400 font-semibold'
                        : 'text-slate-400 hover:text-indigo-400' }}">

                    Liste des clients

                </a>


                <a href="{{ route('clients.create') }}"
                    class="block py-2 text-sm transition-all
                    {{ request()->routeIs('clients.create')
                        ? 'text-indigo-400 font-semibold'
                        : 'text-slate-400 hover:text-indigo-400' }}">

                    Ajouter un client

                </a>

            </div>

        </div>


        <!-- ==================== COMMANDES ==================== -->

        <div class="space-y-1">

            <button
                onclick="toggleSubmenu('menu-commandes', 'icon-commandes')"
                class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all
                {{ request()->routeIs('orders.*')
                    ? 'bg-slate-800 text-white'
                    : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">

                <div class="flex items-center gap-3">

                    <i data-lucide="shopping-cart" class="w-5 h-5"></i>

                    <span class="font-medium">
                        Commandes
                    </span>

                </div>

                <i data-lucide="chevron-down"
                    id="icon-commandes"
                    class="w-4 h-4 rotate-icon">
                </i>

            </button>


            <div id="menu-commandes"
                class="submenu pl-10 space-y-1
                {{ request()->routeIs('orders.*') ? 'open' : '' }}">

                <a href="{{ route('orders.index') }}"
                    class="block py-2 text-sm transition-all
                    {{ request()->routeIs('orders.index')
                        ? 'text-indigo-400 font-semibold'
                        : 'text-slate-400 hover:text-indigo-400' }}">

                    Historique

                </a>


                <a href="{{ route('orders.create') }}"
                    class="block py-2 text-sm transition-all
                    {{ request()->routeIs('orders.create')
                        ? 'text-indigo-400 font-semibold'
                        : 'text-slate-400 hover:text-indigo-400' }}">

                    Nouvelle commande

                </a>

            </div>

        </div>


        <!-- ==================== SYSTÈME ==================== -->

        <div class="pt-6 pb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest px-4">
            Système
        </div>


        {{-- Paramètres --}}
        <a href="{{ route('dashboard.edit') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all
            {{ request()->routeIs('dashboard.edit', 'dashboard.profile.*', 'dashboard.password.*')
                ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/20'
                : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">

            <i data-lucide="settings" class="w-5 h-5"></i>

            <span class="font-medium">
                Paramètres
            </span>

        </a>


        {{-- Déconnexion --}}
        <form action="{{ route('users.logout') }}" method="POST">

            @csrf

            <button type="submit"
                class="w-full flex items-center gap-3 px-4 py-3 text-red-400 hover:bg-red-500/10 rounded-xl transition-all">

                <i data-lucide="log-out" class="w-5 h-5"></i>

                <span class="font-medium">
                    Déconnexion
                </span>

            </button>

        </form>

    </nav>

</aside>