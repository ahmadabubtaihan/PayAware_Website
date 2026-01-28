<nav class="max-w-7xl mx-auto bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-slate-100" dir="ltr">
    <div class="flex justify-between items-center py-4 px-6 md:px-12">
        <div class="text-3xl font-bold text-teal-500 font-cursive cursor-pointer hover:scale-105 transition transform">
            <a href="{{ route('home') }}">payAware</a>
        </div>
            
        <div class="hidden md:flex gap-8 text-sm font-medium text-slate-600" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-teal-600 font-bold border-b-2 border-teal-500 pb-1' : 'hover:text-teal-500 transition' }}">{{ __('strings.home') }}</a>
            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'text-teal-600 font-bold border-b-2 border-teal-500 pb-1' : 'hover:text-teal-500 transition' }}">{{ __('strings.about') }}</a>
            <a href="{{ route('faq') }}" class="{{ request()->routeIs('faq') ? 'text-teal-600 font-bold border-b-2 border-teal-500 pb-1' : 'hover:text-teal-500 transition' }}">{{ __('strings.faq') }}</a>
            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'text-teal-600 font-bold border-b-2 border-teal-500 pb-1' : 'hover:text-teal-500 transition' }}">{{ __('strings.contact') }}</a>
            <a href="{{ route('help') }}" class="{{ request()->routeIs('help') ? 'text-teal-600 font-bold border-b-2 border-teal-500 pb-1' : 'hover:text-teal-500 transition' }}">{{ __('strings.help') }}</a>
        </div>

        <div class="flex items-center space-x-4 text-slate-600">
            
            <div class="relative group">
                <div class="hidden sm:flex items-center space-x-1 cursor-pointer hover:text-teal-500 transition bg-slate-50 px-2 py-1 rounded-full border border-slate-100">
                    <span class="text-lg">{{ app()->getLocale() == 'ar' ? '🇸🇦' : '🇺🇸' }}</span>
                    <i data-lucide="chevron-down" class="w-3.5 h-3.5 ml-1 transition group-hover:rotate-180"></i>
                </div>
                <div class="dropdown-menu absolute top-full right-0 mt-2 w-32 bg-white rounded-xl shadow-xl border border-slate-100 py-2 z-50">
                    <a href="{{ route('switchLang', 'en') }}" class="flex items-center px-4 py-2 hover:bg-slate-50 text-sm text-slate-600 hover:text-teal-500">
                        <span class="mr-2">🇺🇸</span> English
                    </a>
                    <a href="{{ route('switchLang', 'ar') }}" class="flex items-center px-4 py-2 hover:bg-slate-50 text-sm text-slate-600 hover:text-teal-500">
                        <span class="mr-2">🇸🇦</span> العربية
                    </a>
                </div>
            </div>

            <div class="relative flex items-center justify-end">
                <div id="search-box" class="search-container bg-slate-50 rounded-full border border-slate-100 flex items-center h-10">
                    <button onclick="toggleSearch()" class="w-10 h-10 flex items-center justify-center text-slate-500 hover:text-teal-500 transition shrink-0">
                        <i data-lucide="search" class="w-5 h-5"></i>
                    </button>
                    <input type="text" placeholder="{{ __('strings.search') }}" class="bg-transparent border-none outline-none text-sm px-2 w-full text-slate-700 placeholder-slate-400 {{ app()->getLocale() == 'ar' ? 'text-right' : '' }}" />
                </div>
            </div>

            <div class="relative group">
                <button class="flex items-center space-x-1 cursor-pointer hover:text-teal-500 transition p-2 hover:bg-slate-50 rounded-full border border-transparent hover:border-slate-100">
                    <i data-lucide="user" class="w-5 h-5"></i>
                    <i data-lucide="chevron-down" class="w-3.5 h-3.5 hidden sm:block transition group-hover:rotate-180"></i>
                </button>
                
                <div class="dropdown-menu absolute top-full right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-slate-100 py-2 z-50 text-right">
                    
                    <div class="px-4 py-2 border-b border-slate-50 flex justify-between items-center" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
                        <p class="text-xs text-slate-400 font-medium uppercase tracking-wider">{{ __('strings.account') }}</p>
                    </div>

                    @guest
                        <a href="{{ route('login') }}" class="flex items-center px-4 py-3 hover:bg-slate-50 text-sm text-slate-600 hover:text-teal-500 transition" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
                            <i data-lucide="log-in" class="w-4 h-4 mx-3"></i> {{ __('strings.login') }}
                        </a>
                        <a href="{{ route('register') }}" class="flex items-center px-4 py-3 hover:bg-slate-50 text-sm text-slate-600 hover:text-teal-500 transition" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
                            <i data-lucide="user-plus" class="w-4 h-4 mx-3"></i> {{ __('strings.register') }}
                        </a>
                    @endguest

                    @auth
                        <div class="px-4 py-2 text-sm font-bold text-teal-600 bg-teal-50/30" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
                            {{ Auth::user()->name }}
                        </div>

                        @php
                            $dashboardRoute = route('home');
                            if(Auth::user()->role == 'creditor') $dashboardRoute = route('creditor.dashboard');
                            elseif(Auth::user()->role == 'debtor') $dashboardRoute = route('debtor.dashboard');
                            elseif(Auth::user()->role == 'admin') $dashboardRoute = route('admin.dashboard');
                        @endphp

                        <a href="{{ $dashboardRoute }}" class="flex items-center px-4 py-3 hover:bg-slate-50 text-sm text-slate-600 hover:text-teal-500 transition" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
                            <i data-lucide="layout-dashboard" class="w-4 h-4 mx-3"></i> لوحة التحكم
                        </a>

                        <div class="border-t border-slate-50 my-1"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center px-4 py-3 hover:bg-red-50 text-sm text-red-500 hover:text-red-600 transition" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
                                <i data-lucide="log-out" class="w-4 h-4 mx-3"></i> تسجيل خروج
                            </button>
                        </form>
                    @endauth

                </div>
            </div>         

            <button id="mobile-menu-btn" class="md:hidden hover:text-teal-500 transition ml-2">
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>
        </div>
    </div>
</nav>