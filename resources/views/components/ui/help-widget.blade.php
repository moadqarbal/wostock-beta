<style>
    [x-cloak] {
        display: none !important;
    }
</style>

<div
    x-data="{ open: false }"
    class="fixed bottom-6 right-6 z-50"
    @keydown.escape.window="open = false"
>
    {{-- Widget --}}
    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-2 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-2 scale-95"
        class="absolute bottom-16 right-0 w-80 max-w-[calc(100vw-2rem)]"
    >
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl overflow-hidden">

            {{-- Header --}}
            <div class="px-5 py-4 bg-slate-900 text-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-indigo-500 flex items-center justify-center">
                            <i data-lucide="headphones" class="w-5 h-5"></i>
                        </div>

                        <div>
                            <h3 class="font-semibold text-sm">
                                Besoin d'aide ?
                            </h3>

                            <p class="text-xs text-slate-300 mt-0.5">
                                Notre équipe est là pour vous aider
                            </p>
                        </div>
                    </div>

                    <button
                        type="button"
                        @click="open = false"
                        class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-300 hover:text-white hover:bg-white/10 transition"
                    >
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>

            {{-- Content --}}
            <div class="p-4 space-y-3">

                {{-- WhatsApp --}}
                <a
                    href="https://wa.me/212605218908"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 hover:border-green-300 hover:bg-green-50 transition group"
                >
                    <div class="w-10 h-10 rounded-xl bg-green-100 text-green-600 flex items-center justify-center shrink-0">
                        <i data-lucide="message-circle" class="w-5 h-5"></i>
                    </div>

                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-800">
                            WhatsApp
                        </p>

                        <p class="text-xs text-slate-500">
                            Contactez-nous directement
                        </p>
                    </div>

                    <i
                        data-lucide="chevron-right"
                        class="w-4 h-4 text-slate-400 group-hover:text-green-600 transition"
                    ></i>
                </a>

                {{-- Contact --}}
                <a
                    href="{{ route('dashboard.propose-feature') }}"
                    class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 hover:border-indigo-300 hover:bg-indigo-50 transition group"
                >
                    <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
                        <i data-lucide="mail" class="w-5 h-5"></i>
                    </div>

                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-800">
                            Nous contacter
                        </p>

                        <p class="text-xs text-slate-500">
                            Envoyer un message
                        </p>
                    </div>

                    <i
                        data-lucide="chevron-right"
                        class="w-4 h-4 text-slate-400 group-hover:text-indigo-600 transition"
                    ></i>
                </a>

            </div>

            {{-- Footer --}}
            <div class="px-4 pb-4">
                <p class="text-[11px] text-center text-slate-400">
                    Support WoStock
                </p>
            </div>

        </div>
    </div>

    {{-- Floating Button --}}
    <button
        type="button"
        @click="open = !open"
        class="w-14 h-14 rounded-full bg-indigo-600 hover:bg-indigo-700 text-white shadow-lg shadow-indigo-600/30 flex items-center justify-center transition-all duration-200 hover:scale-105 focus:outline-none focus:ring-4 focus:ring-indigo-100"
        :aria-label="open ? 'Fermer le support' : 'Ouvrir le support'"
    >
        <i
            x-show="!open"
            data-lucide="message-circle"
            class="w-6 h-6"
        ></i>

        <i
            x-show="open"
            x-cloak
            data-lucide="x"
            class="w-6 h-6"
        ></i>
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>