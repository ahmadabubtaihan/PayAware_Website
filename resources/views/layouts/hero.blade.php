<main class="max-w-7xl mx-auto px-6 md:px-12 py-12 md:py-20 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center relative {{ $extraClasses ?? '' }}">
    {{-- الخلفية المتحركة --}}
    <div class="absolute top-0 right-0 rtl:right-auto rtl:left-0 -mr-20 rtl:-mr-0 rtl:-ml-20 -mt-20 w-96 h-96 bg-teal-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
    <div class="absolute top-0 left-0 rtl:left-auto rtl:right-0 -ml-20 rtl:-ml-0 rtl:-mr-20 -mt-20 w-96 h-96 bg-indigo-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div>

    {{-- المحتوى النصي --}}
    <div class="space-y-8 animate-fade-in-up z-10">
        <h1 class="text-5xl md:text-6xl font-extrabold text-slate-900 leading-tight tracking-tight">
            {{ __('strings.hero_title') }} <br />
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-indigo-500">{{ __('strings.hero_highlight') }}</span>
        </h1>
        
        <p class="text-slate-500 text-lg leading-relaxed max-w-lg border-l-4 rtl:border-l-0 rtl:border-r-4 border-teal-200 pl-4 rtl:pl-0 rtl:pr-4">
            {{ __('strings.hero_desc') }}
        </p>
        
        <div>
            @if(isset($isLink) && $isLink)
                <a href="{{ $btnLink ?? '#' }}" class="bg-teal-500 hover:bg-teal-600 text-white font-bold py-4 px-10 rounded-xl shadow-lg shadow-teal-200 transition-all transform hover:-translate-y-1 active:scale-95 text-lg inline-block">
                    {{ __($btnText) }}
                </a>
            @else
                <button class="bg-teal-500 hover:bg-teal-600 text-white font-bold py-4 px-10 rounded-xl shadow-lg shadow-teal-200 transition-all transform hover:-translate-y-1 active:scale-95 text-lg">
                    {{ __($btnText) }}
                </button>
            @endif
        </div>
    </div>

    {{-- الرسومات التوضيحية (Dashboard Preview) --}}
    <div class="relative mt-8 lg:mt-0 z-10" dir="ltr">
        <div class="bg-white rounded-[2rem] p-6 shadow-2xl shadow-slate-200 border border-slate-100 relative z-10">
            <div class="flex items-center justify-between mb-6 border-b border-slate-50 pb-4">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-red-400"></div>
                    <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                    <div class="w-3 h-3 rounded-full bg-green-400"></div>
                </div>
                <div class="text-xs font-bold text-slate-300 uppercase tracking-widest">{{ __('strings.dashboard_preview') }}</div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100 shadow-sm relative overflow-hidden group hover:shadow-md transition">
                        <div class="absolute top-0 right-0 w-20 h-20 bg-indigo-50 rounded-bl-full -mr-4 -mt-4 transition group-hover:bg-indigo-100"></div>
                    <h3 class="text-sm font-bold text-slate-700 mb-6 relative z-10">{{ __('strings.device_sessions') }}</h3>
                    <div class="flex flex-col items-center">
                        <div class="relative w-36 h-36 mb-4">
                            <svg viewBox="0 0 36 36" class="w-full h-full transform -rotate-90">
                                <path class="text-slate-200" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="2.5" />
                                <path class="text-indigo-500" stroke-dasharray="60, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" />
                                <path class="text-teal-400" stroke-dasharray="20, 100" stroke-dashoffset="-65" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" />
                            </svg>
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <span class="text-3xl font-extrabold text-slate-800">85%</span>
                                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wide">{{ __('strings.mobile') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="bg-slate-50 p-5 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition">
                        <h3 class="text-xs font-bold text-slate-400 uppercase mb-2">{{ __('strings.weekly_perf') }}</h3>
                        <div class="h-20 w-full relative">
                            <svg viewBox="0 0 100 40" class="w-full h-full" preserveAspectRatio="none">
                                <path d="M0 35 Q 25 10, 50 25 T 100 15" fill="none" stroke="#2DD4BF" stroke-width="3" stroke-linecap="round" />
                                <path d="M0 35 Q 25 10, 50 25 T 100 15 V 40 H 0 Z" fill="rgba(45, 212, 191, 0.1)" />
                            </svg>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-indigo-500 to-purple-600 p-5 rounded-3xl shadow-lg text-white relative overflow-hidden">
                        <i data-lucide="trending-up" class="absolute top-4 right-4 text-white opacity-20 w-12 h-12"></i>
                        <div class="text-xs opacity-80 font-medium mb-1">{{ __('strings.total_savings') }}</div>
                        <div class="text-2xl font-bold">$12,450</div>
                        <div class="mt-3 text-xs bg-white/20 inline-block px-2 py-1 rounded">+15% {{ __('strings.vs_last_month') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="hidden md:flex absolute top-1/2 -left-12 rtl:left-auto rtl:-right-12 bg-white p-4 rounded-2xl shadow-2xl border border-slate-50 w-56 z-20 animate-float items-center gap-4" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
                <div class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center text-orange-500 font-bold text-lg shrink-0">JS</div>
                <div>
                    <div class="text-sm font-bold text-slate-800">Ahmad Ali</div>
                    <div class="text-xs text-slate-400">{{ __('strings.sent_payment') }}</div>
                </div>
                <div class="ml-auto text-teal-500 font-bold text-sm">+$240</div>
        </div>
    </div>
</main>