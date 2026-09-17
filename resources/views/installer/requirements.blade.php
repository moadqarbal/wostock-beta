<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Installation - WoStock beta</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-gray-50 text-gray-900">

    <div class="min-h-screen flex items-center justify-center px-4 py-10">

        <div class="w-full max-w-3xl">

            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold tracking-tight">
                    WoStock beta
                </h1>

                <p class="mt-2 text-sm text-gray-500">
                    Installation
                </p>
            </div>

            <!-- Card -->
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

                <!-- Step -->
                <div class="px-6 py-5 border-b border-gray-200">
                    <div class="flex items-center gap-3">

                        <div class="w-9 h-9 rounded-full bg-gray-900 text-white flex items-center justify-center text-sm font-semibold">
                            1
                        </div>

                        <div>
                            <h2 class="font-semibold">
                                Vérification des prérequis
                            </h2>

                            <p class="text-sm text-gray-500">
                                Vérifiez que votre serveur est compatible avec WoStock.
                            </p>
                        </div>

                    </div>
                </div>

                <!-- Requirements -->
                <div class="p-6">

                    <h3 class="text-sm font-semibold text-gray-900 mb-3">
                        Extensions PHP
                    </h3>

                    <div class="border border-gray-200 rounded-xl divide-y divide-gray-200">

                        @foreach ($requirements as $requirement)

                            <div class="flex items-center justify-between px-4 py-4">

                                <div>
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $requirement['name'] }}
                                    </p>

                                    <p class="text-xs text-gray-500 mt-1">
                                        Requis : {{ $requirement['required'] }}
                                        · Actuel : {{ $requirement['current'] }}
                                    </p>
                                </div>

                                @if ($requirement['passed'])
                                    <span class="inline-flex items-center rounded-full bg-green-50 px-3 py-1 text-xs font-medium text-green-700">
                                        OK
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-red-50 px-3 py-1 text-xs font-medium text-red-700">
                                        Manquant
                                    </span>
                                @endif

                            </div>

                        @endforeach

                    </div>

                    <!-- Permissions -->
                    <h3 class="text-sm font-semibold text-gray-900 mt-8 mb-3">
                        Permissions
                    </h3>

                    <div class="border border-gray-200 rounded-xl divide-y divide-gray-200">

                        @foreach ($permissions as $permission)

                            <div class="flex items-center justify-between px-4 py-4">

                                <div>
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $permission['name'] }}
                                    </p>

                                    <p class="text-xs text-gray-500 mt-1 break-all">
                                        {{ $permission['path'] }}
                                    </p>
                                </div>

                                @if ($permission['passed'])
                                    <span class="inline-flex items-center rounded-full bg-green-50 px-3 py-1 text-xs font-medium text-green-700">
                                        OK
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-red-50 px-3 py-1 text-xs font-medium text-red-700">
                                        Non accessible
                                    </span>
                                @endif

                            </div>

                        @endforeach

                    </div>

                    <!-- Errors -->
                    @if ($errors->any())

                        <div class="mt-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3">

                            <p class="text-sm font-semibold text-red-800">
                                Une erreur est survenue
                            </p>

                            <ul class="mt-2 list-disc list-inside text-sm text-red-700">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>

                        </div>

                    @endif

                    <!-- Continue -->
                    <div class="mt-8 flex justify-end">

                        @if ($requirementsPassed && $permissionsPassed)

                            <a
                                href="{{ route('installer.database') }}"
                                class="inline-flex items-center justify-center rounded-xl bg-gray-900 px-5 py-3 text-sm font-medium text-white hover:bg-gray-800 transition"
                            >
                                Continuer
                            </a>

                        @else

                            <button
                                type="button"
                                disabled
                                class="inline-flex items-center justify-center rounded-xl bg-gray-200 px-5 py-3 text-sm font-medium text-gray-400 cursor-not-allowed"
                            >
                                Continuer
                            </button>

                        @endif

                    </div>

                </div>

            </div>

            <!-- Footer -->
            <div class="text-center mt-6">
                <p class="text-xs text-gray-400">
                    WoStock beta
                </p>
            </div>

        </div>

    </div>

</body>
</html>