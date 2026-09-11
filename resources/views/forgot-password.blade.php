<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>WoStock beta - Mot de passe oublié</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

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

    <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-indigo-600/20 rounded-full blur-[120px] animate-pulse"></div>

    <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-purple-600/20 rounded-full blur-[120px] animate-pulse"
        style="animation-delay: 2s;"></div>

    <div class="w-full max-w-[550px] glass-card rounded-[2.5rem] overflow-hidden shadow-2xl relative z-10">

        <div class="p-8 lg:p-16 bg-slate-950/40">

            <div class="mb-10 text-center">

                <div class="flex justify-center mb-8">
                    <div
                        class="w-14 h-14 bg-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-500/50">
                        <i data-lucide="key-round" class="text-white w-7 h-7"></i>
                    </div>
                </div>

                <h3 class="text-3xl font-black text-white mb-2 uppercase tracking-tight">
                    Mot de passe oublié ?
                </h3>

                <p class="text-slate-400 font-medium">
                    Entrez votre adresse e-mail pour recevoir un lien de réinitialisation.
                </p>

            </div>

            @if (session('status'))
                <div class="mb-6 p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20">
                    <p class="text-sm text-emerald-400 font-medium">
                        {{ session('status') }}
                    </p>
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
                @csrf

                <div class="space-y-2">

                    <label
                        class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">
                        Adresse E-mail
                    </label>

                    <div class="relative">

                        <i data-lucide="mail"
                            class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500">
                        </i>

                        <input type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            placeholder="admin@wobranding.com"
                            class="w-full pl-12 pr-4 py-4 rounded-2xl input-glass outline-none font-medium">

                    </div>

                    @error('email')
                        <p class="text-xs text-red-400">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                <button type="submit"
                    class="group relative w-full py-4 bg-indigo-600 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] overflow-hidden transition-all hover:bg-indigo-500 shadow-xl shadow-indigo-600/20 active:scale-[0.98]">

                    <span class="relative z-10 flex items-center justify-center gap-2">
                        Envoyer le lien

                        <i data-lucide="send"
                            class="w-4 h-4 group-hover:translate-x-1 transition-transform">
                        </i>
                    </span>

                </button>

            </form>

            <div class="mt-10 text-center">

                <a href="{{ route('users.login') }}"
                    class="text-xs text-indigo-400 hover:text-indigo-300 font-semibold">
                    ← Retour à la connexion
                </a>

            </div>

        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>

</body>

</html>