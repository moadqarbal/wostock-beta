<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Erreur serveur - WoStock</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://unpkg.com/lucide@latest"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-[#F8FAFC] text-slate-900">

    <main class="min-h-screen flex items-center justify-center px-6 py-12">

        <div class="w-full max-w-xl text-center">

            <!-- Logo -->

            <div class="mb-10">
                <span class="text-2xl font-black tracking-tight text-slate-900">
                    WoStock
                    <span class="text-indigo-600">beta</span>
                </span>
            </div>

            <!-- Error -->

            <div class="mb-8">

                <div class="text-[110px] sm:text-[140px] leading-none font-black tracking-tighter text-indigo-600">
                    500
                </div>

            </div>

            <!-- Content -->

            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 mb-4">
                Une erreur est survenue
            </h1>

            <p class="text-sm sm:text-base text-slate-500 leading-relaxed max-w-md mx-auto mb-8">
                Désolé, une erreur inattendue s'est produite sur le serveur.
                Veuillez réessayer dans quelques instants.
            </p>

            <!-- Actions -->

            <div class="flex flex-col sm:flex-row items-center justify-center gap-3">

                <a href="{{ route('dashboard.index') }}"
                    class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-indigo-600 text-white text-sm font-bold hover:bg-indigo-700 transition-all shadow-sm">

                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i>

                    Retour au dashboard

                </a>

                <button type="button"
                    onclick="window.location.reload()"
                    class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-white border border-slate-200 text-slate-700 text-sm font-bold hover:bg-slate-50 transition-all">

                    <i data-lucide="refresh-cw" class="w-4 h-4"></i>

                    Réessayer

                </button>

            </div>

            <!-- Footer -->

            <p class="mt-12 text-xs text-slate-400">
                © {{ date('Y') }} WoStock. Tous droits réservés.
            </p>

        </div>

    </main>

    <script>
        lucide.createIcons();
    </script>

</body>
</html>