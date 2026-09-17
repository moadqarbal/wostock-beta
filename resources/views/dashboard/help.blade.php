<x-layout>
    <div class="lg:ml-72 min-h-screen flex flex-col transition-all duration-300 bg-[#F8FAFC] overflow-x-hidden">
        <x-navigation.topbar />
        <main class="p-4 lg:p-8 flex-grow w-full">
            <!-- SECTION 1: SUPPORT & ISSUES -->
            <div class="mb-12">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 bg-indigo-600 text-white rounded-xl shadow-lg shadow-indigo-200">
                        <i data-lucide="life-buoy" class="w-5 h-5"></i>
                    </div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">
                        Assistance WoStock
                    </h1>
                </div>
                <div
                    class="bg-white border border-slate-100 rounded-[2.5rem] p-8 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="max-w-xl">
                        <h2 class="text-xl font-black text-slate-800 mb-2">
                            Vous avez rencontré un problème ؟
                        </h2>
                        <p class="text-slate-500 font-medium leading-relaxed text-sm">
                            Si vous trouvez un bug, une erreur dans les calculs ou si une page ne s'affiche pas
                            correctement, notre équipe est là pour régler ça immédiatement.
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                        <a href="https://api.whatsapp.com/send?phone=212605218908&text=Issue%20WoStock%20:%20"
                            class="flex items-center justify-center gap-2 px-6 py-3.5 bg-emerald-500 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-emerald-600 transition-all shadow-lg shadow-emerald-200">
                            <i data-lucide="message-circle" class="w-4 h-4"></i>
                            Signaler via WhatsApp
                        </a>
                        <a href="mailto:wobranding1@gmail.com"
                            class="flex items-center justify-center gap-2 px-6 py-3.5 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-800 transition-all">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                            Support par Email
                        </a>
                    </div>
                </div>
            </div>
            <!-- SECTION 2: ADS CONSULTANT PRESENTATION -->
            <div class="relative">
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 relative z-10">
                    <!-- Main Bio Card -->
                    <div
                        class="xl:col-span-2 bg-slate-950 rounded-[3rem] p-8 lg:p-12 text-white shadow-sm overflow-hidden relative">
                        <!-- Decor pattern -->
                        <div class="absolute inset-0 opacity-[0.03] pointer-events-none"
                            style="background-image: url('data:image/svg+xml,...');">
                        </div>
                        <div class="relative z-10">
                            <div class="flex items-center gap-4 mb-8">
                                <div
                                    class="w-16 h-16 bg-gradient-to-tr from-indigo-600 to-purple-500 rounded-2xl flex items-center justify-center shadow-xl">
                                    <i data-lucide="trending-up" class="w-8 h-8 text-white"></i>
                                </div>
                                <span class="text-xs font-black uppercase tracking-[0.3em] text-indigo-400">
                                    Ads Consultant
                                </span>
                            </div>
                            <h2 class="text-4xl lg:text-5xl font-black mb-8 leading-[1.1] tracking-tighter text-right"
                                dir="rtl">
                                طلع لبيزنس ديالك <br>
                                <span
                                    class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-emerald-400">
                                    بإعلانات احترافية
                                </span>
                            </h2>
                            <div class="space-y-6 text-right mb-12" dir="rtl">
                                <p class="text-xl text-slate-200 leading-relaxed">
                                    سميتي
                                    <span
                                        class="text-indigo-400 font-black underline decoration-indigo-500/30 underline-offset-8">
                                        معاذ قربال
                                    </span>،
                                    خبير في الاستشارة الإعلانية وتطوير المواقع.
                                </p>
                                <p class="text-lg text-slate-400 font-medium">
                                    كنعاون الشركات باش يكبرو عن طريق استراتيجيات تسويقية ذكية، صفحات هبوط كتجيب
                                    المبيعات، وحلول ويب كتركز على النتائج.
                                </p>
                            </div>
                            <!-- Service Focus Bento -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-10">
                                <div
                                    class="bg-white/5 border border-white/10 p-6 rounded-3xl hover:bg-white/10 transition-all">
                                    <i data-lucide="layout-template"
                                        class="w-8 h-8 text-indigo-400 mb-4"></i>
                                    <h4 class="font-bold text-lg mb-2">
                                        Landing Pages
                                    </h4>
                                    <p class="text-sm text-slate-400" dir="rtl">
                                        أنعاونك بـ Landing Page احترافية كتخلي الزبون يشري بلا ما يفكر، ونحول ليك الـ
                                        Ads لمبيعات حقيقية.
                                    </p>
                                </div>
                                <div
                                    class="bg-white/5 border border-white/10 p-6 rounded-3xl hover:bg-white/10 transition-all">
                                    <i data-lucide="globe"
                                        class="w-8 h-8 text-emerald-400 mb-4"></i>
                                    <h4 class="font-bold text-lg mb-2">
                                        Web Solution
                                    </h4>
                                    <p class="text-sm text-slate-400" dir="rtl">
                                        أنصاوب ليك Site Web متكامل كيعرض السلعة ديالك بأحسن صورة ويسهل عليك عملية البيع
                                        والتدبير.
                                    </p>
                                </div>
                            </div>
                            <div
                                class="pt-8 border-t border-white/10 flex flex-col md:flex-row items-center justify-between gap-6">
                                <p class="text-lg italic text-slate-400 text-center md:text-left" dir="rtl">
                                    “الشغف هو اللي كيصنع البزنس، ولكن البزنس ما يقدرش يصنع الشغف”
                                </p>
                                <a href="https://api.whatsapp.com/send?phone=212605218908&text=Hello%20Moad,%20je%20souhaite%20une%20consultation%20gratuite"
                                    class="px-10 py-5 bg-emerald-500 text-white rounded-[1.5rem] font-black text-sm uppercase tracking-widest hover:bg-emerald-400 transition-all shadow-sm shadow-emerald-500/20 active:scale-95 whitespace-nowrap">
                                    ابدأ الآن
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Consultation Side Card -->
                    <div
                        class="bg-white rounded-[3rem] p-8 border border-slate-100 shadow-sm flex flex-col">
                        <div class="mb-8">
                            <span
                                class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-[10px] font-black uppercase tracking-widest">
                                Offre Spéciale
                            </span>
                            <h3 class="text-2xl font-black text-slate-900 mt-4 leading-tight" dir="rtl">
                                استشارة مجانية (15 دقيقة)
                            </h3>
                        </div>
                        <div class="space-y-6 flex-grow" dir="rtl">
                            <div class="flex gap-4">
                                <div
                                    class="w-8 h-8 rounded-full bg-indigo-50 flex items-center justify-center flex-shrink-0 text-indigo-600 font-black text-xs">
                                    1
                                </div>
                                <p class="text-sm text-slate-600 font-medium">
                                    غادي نهضرو على كيفاش تبدا الإعلانات بطريقة صحيحة وشنو أول خطوة خاصك تدير.
                                </p>
                            </div>
                            <div class="flex gap-4">
                                <div
                                    class="w-8 h-8 rounded-full bg-indigo-50 flex items-center justify-center flex-shrink-0 text-indigo-600 font-black text-xs">
                                    2
                                </div>
                                <p class="text-sm text-slate-600 font-medium">
                                    كيفاش تختار الهدف ديال الحملة (Campaign Goal) المناسب للبيزنس ديالك.
                                </p>
                            </div>
                            <div class="flex gap-4">
                                <div
                                    class="w-8 h-8 rounded-full bg-indigo-50 flex items-center justify-center flex-shrink-0 text-indigo-600 font-black text-xs">
                                    3
                                </div>
                                <p class="text-sm text-slate-600 font-medium">
                                    شنو الأخطاء اللي كيديرو بزاف ديال الناس فالبداية وكيضيعو ليهم الفلوس بلا نتائج.
                                </p>
                            </div>
                            <div class="mt-8 p-5 bg-slate-50 rounded-3xl border border-slate-100">
                                <p class="text-xs text-slate-500 leading-relaxed font-bold">
                                    غادي تاخد تصور واضح على شنو خاصك دير باش تبدا بإعلانات منظمة وتجيب أول العملاء بأقل
                                    ميزانية ممكنة.
                                </p>
                            </div>
                        </div>
                        <div class="mt-10 pt-6 border-t border-slate-50">
                            <div class="flex flex-col gap-3">
                                <div
                                    class="flex items-center justify-between text-[10px] font-black text-slate-400 uppercase tracking-widest px-2">
                                    <span>Disponibilité</span>
                                    <span class="text-emerald-500">
                                        En ligne
                                    </span>
                                </div>
                                <a href="https://wobranding.com/" target="_blank"
                                    class="flex items-center justify-center gap-2 text-indigo-600 font-black text-xs uppercase tracking-widest hover:underline py-2">
                                    <i data-lucide="globe" class="w-4 h-4"></i>
                                    Visiter wobranding.com
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer Signature -->
            <div class="mt-16 text-center">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.5em]">
                    Copyright © {{ date('Y') }} - Created by Moad
                </p>
            </div>
        </main>
    </div>
    <script>
        lucide.createIcons();
    </script>
</x-layout>