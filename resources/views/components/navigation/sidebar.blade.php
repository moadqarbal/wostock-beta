<aside id="sidebar"
    class="fixed inset-y-0 left-0 w-72 bg-slate-900 text-white transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-50 flex flex-col">
    <!-- Logo -->
    <div class="flex items-center justify-between h-20 px-6 bg-slate-950">
        <span class="text-2xl font-black tracking-tighter flex items-center gap-2">
            <i data-lucide="package" class="text-indigo-500"></i>
            WoStock <span
                class="text-xs font-medium bg-indigo-600 px-1.5 py-0.5 rounded text-white ml-1 uppercase">beta</span>
        </span>
        <button onclick="toggleSidebar()" class="lg:hidden">
            <i data-lucide="x" class="w-6 h-6"></i>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-grow mt-4 px-4 space-y-1 overflow-y-auto custom-scrollbar">

        <a href="#"
            class="flex items-center gap-3 px-4 py-3 bg-indigo-600 rounded-xl text-white shadow-lg shadow-indigo-900/20">
            <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
            <span class="font-medium">Tableau de bord</span>
        </a>

        <a href="/settings/analysis.php"
            class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl transition-all">
            <i data-lucide="line-chart" class="w-5 h-5"></i>
            <span class="font-medium">Analyses</span>
        </a>

        <!-- Menu Produits -->
        <div class="space-y-1">
            <button onclick="toggleSubmenu('menu-produits', 'icon-produits')"
                class="w-full flex items-center justify-between px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl transition-all">
                <div class="flex items-center gap-3">
                    <i data-lucide="box" class="w-5 h-5"></i>
                    <span class="font-medium">Produits</span>
                </div>
                <i data-lucide="chevron-down" id="icon-produits" class="w-4 h-4 rotate-icon"></i>
            </button>
            <div id="menu-produits" class="submenu pl-10 space-y-1">
                <a href="/products/add-product.php"
                    class="block py-2 text-sm text-slate-400 hover:text-indigo-400">Ajouter un produit</a>
                <a href="/products/list-product.php"
                    class="block py-2 text-sm text-slate-400 hover:text-indigo-400">Liste des produits</a>
                <a href="/products/categories-product.php"
                    class="block py-2 text-sm text-slate-400 hover:text-indigo-400">Catégories</a>
            </div>
        </div>

        <!-- Menu Fournisseurs -->
        <div class="space-y-1">
            <button onclick="toggleSubmenu('menu-fourn', 'icon-fourn')"
                class="w-full flex items-center justify-between px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl transition-all">
                <div class="flex items-center gap-3">
                    <i data-lucide="truck" class="w-5 h-5"></i>
                    <span class="font-medium">Fournisseurs</span>
                </div>
                <i data-lucide="chevron-down" id="icon-fourn" class="w-4 h-4 rotate-icon"></i>
            </button>
            <div id="menu-fourn" class="submenu pl-10 space-y-1">
                <a href="/suppliers/add-supplier.php"
                    class="block py-2 text-sm text-slate-400 hover:text-indigo-400">Ajouter fournisseur</a>
                <a href="/suppliers/list-supplier.php"
                    class="block py-2 text-sm text-slate-400 hover:text-indigo-400">Liste fournisseurs</a>
            </div>
        </div>

        <!-- Menu Clients -->
        <div class="space-y-1">
            <button onclick="toggleSubmenu('menu-clients', 'icon-clients')"
                class="w-full flex items-center justify-between px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl transition-all">
                <div class="flex items-center gap-3">
                    <i data-lucide="users" class="w-5 h-5"></i>
                    <span class="font-medium">Clients</span>
                </div>
                <i data-lucide="chevron-down" id="icon-clients" class="w-4 h-4 rotate-icon"></i>
            </button>
            <div id="menu-clients" class="submenu pl-10 space-y-1">
                <a href="/clients/add-client.php"
                    class="block py-2 text-sm text-slate-400 hover:text-indigo-400">Ajouter un client</a>
                <a href="/clients/list-client.php" class="block py-2 text-sm text-slate-400 hover:text-indigo-400">Liste
                    des clients</a>
            </div>
        </div>

        <!-- Menu Commandes -->
        <div class="space-y-1">
            <button onclick="toggleSubmenu('menu-commandes', 'icon-commandes')"
                class="w-full flex items-center justify-between px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl transition-all">
                <div class="flex items-center gap-3">
                    <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                    <span class="font-medium">Commandes</span>
                </div>
                <i data-lucide="chevron-down" id="icon-commandes" class="w-4 h-4 rotate-icon"></i>
            </button>
            <div id="menu-commandes" class="submenu pl-10 space-y-1">
                <a href="/orders/add-order.php" class="block py-2 text-sm text-slate-400 hover:text-indigo-400">Nouvelle
                    commande</a>
                <a href="/orders/list-order.php"
                    class="block py-2 text-sm text-slate-400 hover:text-indigo-400">Historique</a>
            </div>
        </div>

        <div class="pt-6 pb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest px-4">Système</div>

        <a href="/settings/settings.php"
            class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl transition-all">
            <i data-lucide="settings" class="w-5 h-5"></i>
            <span class="font-medium">Paramètres</span>
        </a>
        <a href="#"
            class="flex items-center gap-3 px-4 py-3 text-red-400 hover:bg-red-500/10 rounded-xl transition-all">
            <i data-lucide="log-out" class="w-5 h-5"></i>
            <span class="font-medium">Déconnexion</span>
        </a>
    </nav>
</aside>
