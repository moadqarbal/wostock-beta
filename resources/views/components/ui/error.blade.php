@if ($errors->any() || session()->has('error'))

    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 5000)"
        x-show="show"
        x-transition
        class="fixed top-6 right-6 z-50 w-[430px] overflow-hidden rounded-xl bg-red-600 text-white shadow-xl"
    >

        <div class="flex items-start gap-4 p-5">

            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-white/20">
                <i data-lucide="circle-alert" class="h-6 w-6"></i>
            </div>

            <div class="min-w-0 flex-1">

                <h3 class="text-base font-semibold">
                    Une erreur est survenue
                </h3>

                <p class="mt-1 text-sm text-red-50">
                    @if (session()->has('error'))
                        {{ session('error') }}
                    @else
                        {{ $errors->first() }}
                    @endif
                </p>

            </div>

            <button
                type="button"
                @click="show = false"
                class="text-white/70 transition hover:text-white"
            >
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>

        </div>

        <div class="h-1 bg-red-800/30">
            <div
                class="h-full bg-white/80"
                style="width: 100%; animation: error-progress 5s linear forwards;"
            ></div>
        </div>

    </div>

    <style>
        @keyframes error-progress {
            from {
                width: 100%;
            }

            to {
                width: 0%;
            }
        }
    </style>

    <script>
        lucide.createIcons();
    </script>

@endif