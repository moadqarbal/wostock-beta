<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WoStock beta - Connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Animation dyal background */
        .bg-animate {
            background: linear-gradient(-45deg, #0f172a, #1e1b4b, #312e81, #1e1b4b);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Glassmorphism effect */
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .input-glass {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            transition: all 0.3s ease;
        }

        .input-glass:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: #6366f1;
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.2);
        }
    </style>
</head>

<body class="bg-animate min-h-screen flex items-center justify-center p-4 overflow-hidden relative">

    <!-- Decor circles -->
    <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-indigo-600/20 rounded-full blur-[120px] animate-pulse">
    </div>
    <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-purple-600/20 rounded-full blur-[120px] animate-pulse"
        style="animation-delay: 2s;"></div>

    <div
        class="w-full max-w-[1100px] grid grid-cols-1 lg:grid-cols-2 glass-card rounded-[2.5rem] overflow-hidden shadow-2xl relative z-10">

        <!-- Left Side: Branding & Creative -->
        <div
            class="hidden lg:flex flex-col justify-between p-12 bg-white/5 border-r border-white/10 relative overflow-hidden">
            <!-- Pattern decor -->
            <div class="absolute inset-0 opacity-10 pointer-events-none"
                style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 30px 30px;"></div>

            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-12">
                    <div
                        class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-500/50">
                        <i data-lucide="package" class="text-white w-7 h-7"></i>
                    </div>
                    <span class="text-2xl font-black text-white tracking-tighter">WoStock <span
                            class="text-[10px] bg-indigo-600 px-2 py-0.5 rounded-full uppercase ml-1">beta</span></span>
                </div>

                <h2 class="text-5xl font-black text-white leading-tight mb-6">
                    Gérez votre <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-emerald-400">Stock &
                        Ventes</span> <br>
                    avec élégance.
                </h2>
                <p class="text-slate-400 text-lg max-w-md font-medium">
                    L'interface la plus intuitive pour propulser votre e-commerce vers de nouveaux sommets.
                </p>
            </div>

            <div class="relative z-10">
                <div class="flex items-center gap-4 p-4 bg-white/5 rounded-2xl border border-white/5 inline-flex">
                    <div class="flex -space-x-3">
                        <div class="w-8 h-8 rounded-full border-2 border-slate-900 bg-indigo-500"></div>
                        <div class="w-8 h-8 rounded-full border-2 border-slate-900 bg-emerald-500"></div>
                        <div class="w-8 h-8 rounded-full border-2 border-slate-900 bg-purple-500"></div>
                    </div>
                    <p class="text-xs font-bold text-slate-300 uppercase tracking-widest">+500 Entreprises nous font
                        confiance</p>
                </div>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="p-8 lg:p-16 flex flex-col justify-center bg-slate-950/40">
            <div class="mb-10 text-center lg:text-left">
                <h3 class="text-3xl font-black text-white mb-2 uppercase tracking-tight">Bon retour !</h3>
                <p class="text-slate-400 font-medium">Identifiez-vous pour accéder au dashboard.</p>
            </div>

            <form action="{{ route('authenticate') }}" method="POST" class="space-y-6" onsubmit="handleLogin(event)">
                @csrf
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Adresse
                        E-mail</label>
                    <div class="relative">
                        <i data-lucide="mail"
                            class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            placeholder="admin@wobranding.com"
                            class="w-full pl-12 pr-4 py-4 rounded-2xl input-glass outline-none font-medium">
                    </div>
                    @error('email')
                        <p class="text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <div class="relative">
                        <i data-lucide="lock"
                            class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500"></i>
                        <input type="password" name="password" required placeholder="••••••••"
                            class="w-full pl-12 pr-4 py-4 rounded-2xl input-glass outline-none font-medium">
                    </div>
                    @error('password')
                        <p class="text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between px-1">
                    <div class="flex items-center gap-3">
                        <input type="checkbox" id="remember" name="remember"
                            class="w-4 h-4 rounded border-white/10 bg-white/5 text-indigo-600 focus:ring-indigo-500">

                        <label for="remember" class="text-xs text-slate-400 font-medium cursor-pointer">
                            Se souvenir de moi
                        </label>
                    </div>

                    <a href="{{ route('password.request') }}"
                        class="text-xs text-indigo-400 hover:text-indigo-300 font-semibold transition">
                        Mot de passe oublié ?
                    </a>
                </div>

                <button type="submit" id="loginBtn"
                    class="group relative w-full py-4 bg-indigo-600 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] overflow-hidden transition-all hover:bg-indigo-500 shadow-xl shadow-indigo-600/20 active:scale-[0.98]">
                    <span class="relative z-10 flex items-center justify-center gap-2">
                        Connexion <i data-lucide="arrow-right"
                            class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                    </span>
                    <!-- Shine Effect -->
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:animate-[shimmer_2s_infinite]">
                    </div>
                </button>
            </form>

            <div class="mt-12 text-center">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em]">
                    Powered by
                    <a href="https://wobranding.com" target="_blank"
                        class="text-indigo-400 hover:text-indigo-300 hover:underline">
                        WoBranding
                    </a>
                </p>

                <p class="mt-4">
                    <a class="text-xs font-bold text-indigo-400 hover:text-indigo-300 hover:underline transition"
                        href="{{ route('users.create') }}">
                        Vous n’avez pas de compte ?
                    </a>
                </p>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

        function handleLogin(e) {
            const btn = document.getElementById('loginBtn');

            btn.innerHTML = `
            <i data-lucide="loader-2" class="w-5 h-5 animate-spin"></i>
            Authentification...
        `;

            lucide.createIcons();
            btn.disabled = true;
        }
    </script>

    <style>
        @keyframes shimmer {
            100% {
                transform: translateX(100%);
            }
        }
    </style>
</body>

</html>
