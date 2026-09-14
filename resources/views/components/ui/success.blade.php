@if (session()->has('success'))
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 5000)"
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-x-5"
        x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 translate-x-5"
        class="fixed top-6 right-6 z-50 w-[430px] overflow-hidden rounded-xl bg-green-600 text-white shadow-xl"
    >
        <div class="flex items-start gap-4 p-5">

            {{-- Icon --}}
            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-white/20">
                <i data-lucide="circle-check" class="h-6 w-6"></i>
            </div>

            {{-- Content --}}
            <div class="min-w-0 flex-1">
                <h3 class="text-base font-semibold">
                    Succès
                </h3>

                <p class="mt-1 text-sm text-green-50">
                    {{ session('success') }}
                </p>
            </div>

            {{-- Close --}}
            <button
                type="button"
                @click="show = false"
                class="text-white/70 transition hover:text-white"
            >
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>
        </div>

        {{-- Progress --}}
        <div class="h-1 bg-green-800/30">
            <div
                class="h-full bg-white/80"
                style="width: 100%; animation: success-progress 5s linear forwards;"
            ></div>
        </div>
    </div>

    <style>
        @keyframes success-progress {
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