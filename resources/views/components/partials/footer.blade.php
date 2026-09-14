<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<x-ui.success />
<x-ui.error />


<script>
    // 1. Initialisation globale des icônes au chargement
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
    });

    // 2. Gestion de la Sidebar (Mobile)
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    }

    // 3. Gestion des Sous-menus de la Sidebar (Accordéons)
    function toggleSubmenu(id, iconId) {
        const submenu = document.getElementById(id);
        const icon = document.getElementById(iconId);

        // Fermer les autres sous-menus ouverts pour un look propre
        document.querySelectorAll('.submenu').forEach(el => {
            if (el.id !== id && el.classList.contains('open')) {
                el.classList.remove('open');
                // Réinitialiser les icônes des autres menus
                const otherIcon = document.querySelector(`[id^="icon-"]`);
                // Note: idéalement cibler plus précisément l'icône associée
            }
        });

        submenu.classList.toggle('open');
        if (icon) icon.classList.toggle('active');
    }

    // 4. Gestion du Menu Profil (Navbar)
    function toggleUserMenu() {
        const menu = document.getElementById('userMenu');
        menu.classList.toggle('hidden');
    }

    // 5. Fermeture des menus au clic extérieur (Global)
    window.addEventListener('click', function(e) {
        // Pour le menu profil
        const userMenu = document.getElementById('userMenu');
        const userBtn = document.querySelector('button[onclick="toggleUserMenu()"]');
        if (userMenu && !userMenu.classList.contains('hidden')) {
            if (!userMenu.contains(e.target) && !userBtn.contains(e.target)) {
                userMenu.classList.add('hidden');
            }
        }
    });

    // 6. Listener pour l'overlay mobile
    const overlay = document.getElementById('sidebarOverlay');
    if (overlay) {
        overlay.onclick = toggleSidebar;
    }
</script>