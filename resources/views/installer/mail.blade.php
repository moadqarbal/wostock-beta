<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mail - WoStock Installer</title>

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
                Step 4 of 6
            </p>

            <h1 class="mt-2 text-2xl font-bold text-gray-900">
                Mail / SMTP
            </h1>

            <p class="mt-2 text-sm text-gray-500">
                Configure SMTP so WoStock can send emails.
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

        <form method="POST" action="{{ route('installer.mail.test') }}" class="space-y-5">
            @csrf

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    SMTP Host
                </label>

                <input
                    type="text"
                    name="host"
                    value="{{ old('host') }}"
                    
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none focus:border-gray-900"
                    placeholder="smtp.example.com"
                >
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    SMTP Port
                </label>

                <input
                    type="number"
                    name="port"
                    value="{{ old('port', '587') }}"
                    
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none focus:border-gray-900"
                    placeholder="587"
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
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none focus:border-gray-900"
                    placeholder="mail@example.com"
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
                >
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Encryption
                </label>

                <select
                    name="encryption"
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm outline-none focus:border-gray-900"
                >
                    <option value="">None</option>
                    <option value="tls" @selected(old('encryption') === 'tls')>
                        TLS
                    </option>
                    <option value="ssl" @selected(old('encryption') === 'ssl')>
                        SSL
                    </option>
                </select>
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    From Address
                </label>

                <input
                    type="email"
                    name="from_address"
                    value="{{ old('from_address') }}"
                    
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none focus:border-gray-900"
                    placeholder="no-reply@example.com"
                >
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    From Name
                </label>

                <input
                    type="text"
                    name="from_name"
                    value="{{ old('from_name', 'WoStock') }}"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none focus:border-gray-900"
                    placeholder="WoStock"
                >
            </div>

            <button
                type="submit"
                class="w-full rounded-lg bg-gray-900 px-5 py-3 text-sm font-semibold text-white hover:bg-gray-800"
            >
                Test SMTP & Continue
            </button>

        </form>

    </div>

</div>

</body>
</html>