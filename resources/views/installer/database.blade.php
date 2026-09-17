<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Database - WoStock Installer</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >
</head>

<body class="min-h-screen bg-gray-50 font-[Inter]">

<div class="mx-auto flex min-h-screen max-w-2xl items-center px-6 py-12">

    <div class="w-full rounded-2xl bg-white p-8 shadow-sm ring-1 ring-gray-200">

        <div class="mb-8">
            <p class="text-sm font-medium text-gray-500">
                Step 2 of 6
            </p>

            <h1 class="mt-2 text-2xl font-bold text-gray-900">
                Database Configuration
            </h1>

            <p class="mt-2 text-sm text-gray-500">
                Enter the database credentials provided by your hosting provider.
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4">
                <ul class="list-disc pl-5 text-sm text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('installer.database.test') }}" class="space-y-5">
            @csrf

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Database Host
                </label>

                <input
                    type="text"
                    name="host"
                    value="{{ old('host', '127.0.0.1') }}"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none focus:border-gray-900"
                    placeholder="127.0.0.1"
                >
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Port
                </label>

                <input
                    type="number"
                    name="port"
                    value="{{ old('port', '3306') }}"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none focus:border-gray-900"
                    placeholder="3306"
                >
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Database Name
                </label>

                <input
                    type="text"
                    name="database"
                    value="{{ old('database') }}"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none focus:border-gray-900"
                    placeholder="wostock"
                >
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Username
                </label>

                <input
                    type="text"
                    name="username"
                    value="{{ old('username') }}"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none focus:border-gray-900"
                    placeholder="database username"
                >
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none focus:border-gray-900"
                    placeholder="Database password"
                >
            </div>

            <button
                type="submit"
                class="w-full rounded-lg bg-gray-900 px-5 py-3 text-sm font-semibold text-white hover:bg-gray-800"
            >
                Test Connection & Continue
            </button>

        </form>

    </div>

</div>

</body>
</html>