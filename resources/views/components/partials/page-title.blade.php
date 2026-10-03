<title>
    WoStock Admin -
    {{
        [
            // Dashboard
            'dashboard.index' => 'Tableau de Bord',
            'dashboard.analytics' => 'Analytics',
            'dashboard.help' => 'Aide',
            'dashboard.propose-feature' => 'Proposer une Fonctionnalité',
            'dashboard.analytics.export' => 'Export Analytics',
            'dashboard.edit' => 'Mon Profil',

            // Products
            'products.index' => 'Produits',
            'products.create' => 'Ajouter un Produit',
            'products.show' => 'Détails du Produit',
            'products.edit' => 'Modifier le Produit',
            'products.trashed' => 'Produits Supprimés',

            // Categories
            'categories.index' => 'Catégories',
            'categories.create' => 'Ajouter une Catégorie',
            'categories.edit' => 'Modifier la Catégorie',

            // Clients
            'clients.index' => 'Clients',
            'clients.create' => 'Ajouter un Client',
            'clients.show' => 'Détails du Client',
            'clients.edit' => 'Modifier le Client',

            // Suppliers
            'suppliers.index' => 'Fournisseurs',
            'suppliers.create' => 'Ajouter un Fournisseur',
            'suppliers.show' => 'Détails du Fournisseur',
            'suppliers.edit' => 'Modifier le Fournisseur',

            // Orders
            'orders.index' => 'Commandes',
            'orders.create' => 'Ajouter une Commande',
            'orders.show' => 'Détails de la Commande',
            'orders.edit' => 'Modifier la Commande',

            // Authentication
            'users.login' => 'Connexion',
            'password.request' => 'Mot de passe oublié',
            'password.reset' => 'Réinitialiser le mot de passe',

            // Errors
            'dashboard.error-404' => 'Page introuvable',
            'dashboard.error-500' => 'Erreur serveur',

            // Installer
            'installer.requirements' => 'Installation - Vérification',
            'installer.database' => 'Installation - Base de données',
            'installer.application' => 'Installation - Application',
            'installer.mail' => 'Installation - Email',
            'installer.admin' => 'Installation - Administrateur',
            'installer.install' => 'Installation - Finalisation',

        ][Route::currentRouteName()] ?? 'WoStock'
    }}
</title>