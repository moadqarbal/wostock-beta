<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Install - WoStock</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >
</head>

<body class="min-h-screen bg-gray-50 font-[Inter]">

    <div class="mx-auto flex min-h-screen max-w-3xl items-center justify-center px-6 py-12">

        <div class="w-full rounded-2xl bg-white p-8 shadow-sm ring-1 ring-gray-200">

            <div class="mb-8 text-center">
                <h1 class="text-2xl font-bold text-gray-900">
                    WoStock Installer
                </h1>

                <p class="mt-2 text-sm text-gray-500">
                    Ready to install WoStock.
                </p>
            </div>

            @if ($errors->any())
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4">
                    <p class="font-medium text-red-800">
                        Installation failed
                    </p>

                    <ul class="mt-2 list-disc pl-5 text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-8 space-y-3">

                <div class="flex items-center gap-3 rounded-lg border border-green-200 bg-green-50 p-4">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-600 text-sm font-semibold text-white">
                        ✓
                    </div>

                    <div>
                        <p class="font-medium text-gray-900">
                            Requirements
                        </p>

                        <p class="text-sm text-gray-500">
                            Server requirements checked
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3 rounded-lg border border-green-200 bg-green-50 p-4">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-600 text-sm font-semibold text-white">
                        ✓
                    </div>

                    <div>
                        <p class="font-medium text-gray-900">
                            Database
                        </p>

                        <p class="text-sm text-gray-500">
                            Database connection configured
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3 rounded-lg border border-green-200 bg-green-50 p-4">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-600 text-sm font-semibold text-white">
                        ✓
                    </div>

                    <div>
                        <p class="font-medium text-gray-900">
                            Application
                        </p>

                        <p class="text-sm text-gray-500">
                            Application settings configured
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3 rounded-lg border border-green-200 bg-green-50 p-4">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-600 text-sm font-semibold text-white">
                        ✓
                    </div>

                    <div>
                        <p class="font-medium text-gray-900">
                            Mail / SMTP
                        </p>

                        <p class="text-sm text-gray-500">
                            Mail settings configured
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3 rounded-lg border border-green-200 bg-green-50 p-4">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-600 text-sm font-semibold text-white">
                        ✓
                    </div>

                    <div>
                        <p class="font-medium text-gray-900">
                            Admin Account
                        </p>

                        <p class="text-sm text-gray-500">
                            Administrator account configured
                        </p>
                    </div>
                </div>

            </div>

            <form
                method="POST"
                action="{{ route('installer.install.run') }}"
            >
                @csrf

                <button
                    type="submit"
                    class="w-full rounded-lg bg-gray-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-gray-800"
                >
                    Install WoStock
                </button>
            </form>

        </div>

    </div>

</body>
</html>