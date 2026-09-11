<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WoStock beta - Configuration Initiale</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            background-image: radial-gradient(#e2e8f0 1px, transparent 1px);
            background-size: 30px 30px;
        }

        .setup-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }

        .input-field {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease-in-out;
        }

        .input-field:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
            outline: none;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-[500px]">

        <!-- Header -->
        <div class="text-center mb-10">
            <div
                class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-3xl shadow-xl shadow-slate-200/50 mb-6">
                <i data-lucide="sparkles" class="text-indigo-600 w-10 h-10"></i>
            </div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Bienvenue</h1>
            <p class="text-slate-500 font-medium mt-2">Créez votre compte administrateur WoStock</p>
        </div>

        <!-- Main Card -->
        <div class="setup-card rounded-[2.5rem] p-8 lg:p-12 shadow-2xl shadow-slate-200 border border-white">
            <form method="POST" action="{{ route('users.store') }}" class="space-y-5" onsubmit="handleRegister(event)">

                @csrf

                <!-- Username -->
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Nom
                        d'utilisateur</label>
                    <div class="relative">
                        <i data-lucide="user"
                            class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                        <input type="text" name="name" id="username" value="{{ old('name') }}"
                            placeholder="ex: moad_admin"
                            class="w-full pl-12 pr-4 py-4 rounded-2xl input-field font-semibold text-slate-700">
                        @error('name')
                            <p class="text-xs text-red-500 mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Email -->
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Adresse
                        Email</label>
                    <div class="relative">
                        <i data-lucide="at-sign"
                            class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            placeholder="votre@email.com"
                            class="w-full pl-12 pr-4 py-4 rounded-2xl input-field font-semibold text-slate-700">
                        @error('email')
                            <p class="text-xs text-red-500 mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Mot de
                        passe</label>
                    <div class="relative">
                        <i data-lucide="key-round"
                            class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                        <input name="password" type="password" value="{{ old('password') }}" id="password"
                            placeholder="••••••••"
                            class="w-full pl-12 pr-4 py-4 rounded-2xl input-field font-semibold text-slate-700">
                        @error('password')
                            <p class="text-xs text-red-500 mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="space-y-2">
                    <label
                        class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Confirmation</label>
                    <div class="relative">
                        <i data-lucide="shield-check"
                            class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                        <input type="password" name="password_confirmation" id="confirm_password" placeholder="••••••••"
                            class="w-full pl-12 pr-4 py-4 rounded-2xl input-field font-semibold text-slate-700">
                        @error('password_confirmation')
                            <p class="text-xs text-red-500 mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Important Note -->
                <div class="p-4 bg-indigo-50 border border-indigo-100 rounded-2xl flex items-start gap-3">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-indigo-500 flex-shrink-0 mt-0.5"></i>
                    <p class="text-[11px] text-indigo-700/80 leading-relaxed font-semibold">
                        Cette étape de configuration est unique. Veuillez conserver vos identifiants en lieu sûr.
                    </p>
                </div>

                <button type="submit" id="regBtn"
                    class="group relative w-full py-5 bg-indigo-600 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all hover:bg-indigo-700 shadow-xl shadow-indigo-200 active:scale-[0.98] mt-4 flex items-center justify-center gap-3">
                    Finaliser l'installation
                    <i data-lucide="arrow-right" class="w-5 h-5 transition-transform group-hover:translate-x-1"></i>
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="mt-12 text-center">
            <div class="flex items-center justify-center gap-2 mb-2">
                <div class="w-6 h-6 bg-slate-200 rounded flex items-center justify-center">
                    <i data-lucide="package" class="text-slate-500 w-3.5 h-3.5"></i>
                </div>
                <span class="text-xs font-black text-slate-400 tracking-tighter uppercase">
                    WoStock beta
                </span>
            </div>

            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.4em]">
                Propulsé par WoBranding
            </p>

            <a href="{{ route('users.login') }}"
                class="inline-block mt-3 text-[10px] font-bold text-indigo-400 hover:text-indigo-300 hover:underline uppercase tracking-wider transition">
                Déjà un compte ? Se connecter
            </a>
        </div>
    </div>

    <script>
        lucide.createIcons();

        function handleRegister(e) {
            const btn = document.getElementById('regBtn');

            btn.innerHTML = `
            <i data-lucide="loader-2" class="w-5 h-5 animate-spin"></i>
            CRÉATION EN COURS...
        `;

            lucide.createIcons();
            btn.disabled = true;
        }
    </script>
</body>

</html>
