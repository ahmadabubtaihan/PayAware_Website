<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - @yield('title')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    @stack('head-scripts')

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        cairo: ['Cairo', 'sans-serif'],
                    },
                    colors: {
                        slate: { 850: '#1e293b' } 
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="{{ asset('css/adminNav.css') }}">
</head>
<body class="h-screen flex overflow-hidden text-slate-800">

    {{-- ========================================== --}}
    {{-- القائمة الجانبية --}}
    {{-- ========================================== --}}
    <aside class="w-64 bg-slate-900 text-white flex flex-col transition-all duration-300 fixed md:relative z-30 h-full hidden md:flex" id="sidebar">
        <div class="h-20 flex items-center px-8 border-b border-slate-800">
            <a href="{{ route('admin.dashboard') }}" class="text-2xl font-extrabold tracking-tight text-white flex items-center gap-2">
                <div class="w-8 h-8 bg-teal-500 rounded-lg flex items-center justify-center text-slate-900">
                    <i data-lucide="shield-check" class="w-5 h-5"></i>
                </div>
                payAware <span class="text-xs bg-slate-800 text-slate-400 px-2 py-0.5 rounded ml-2 rtl:mr-2 rtl:ml-0">Admin</span>
            </a>
        </div>

        <div class="flex-1 overflow-y-auto custom-scroll py-6 px-4 space-y-1">
            <p class="px-4 text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">{{ __('strings.main_menu') ?? 'القائمة الرئيسية' }}</p>
            
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-teal-600 text-white shadow-lg shadow-teal-900/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i> {{ __('strings.dashboard') ?? 'لوحة التحكم' }}
            </a>

            <a href="{{ route('admin.companies') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition {{ request()->routeIs('admin.companies') ? 'bg-teal-600 text-white shadow-lg shadow-teal-900/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i data-lucide="building-2" class="w-5 h-5"></i> {{ __('strings.companies') ?? 'الشركات' }}
            </a>

            <a href="{{ route('admin.roles') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition {{ request()->routeIs('admin.roles') ? 'bg-teal-600 text-white shadow-lg shadow-teal-900/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i data-lucide="shield" class="w-5 h-5"></i> {{ __('strings.roles') ?? 'الصلاحيات' }}
            </a>

            <p class="px-4 text-xs font-bold text-slate-500 uppercase tracking-wider mt-8 mb-2">{{ __('strings.system') ?? 'النظام' }}</p>

            <a href="{{ route('admin.logs') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition {{ request()->routeIs('admin.logs') ? 'bg-teal-600 text-white shadow-lg shadow-teal-900/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i data-lucide="activity" class="w-5 h-5"></i> {{ __('strings.logs') ?? 'سجلات النظام' }}
            </a>

            <a href="{{ route('admin.backups') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition {{ request()->routeIs('admin.backups') ? 'bg-teal-600 text-white shadow-lg shadow-teal-900/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i data-lucide="database" class="w-5 h-5"></i> {{ __('strings.backups') ?? 'النسخ الاحتياطي' }}
            </a>
        </div>

        <div class="p-4 border-t border-slate-800">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 text-slate-400 hover:text-red-400 hover:bg-red-900/10 rounded-xl transition font-medium">
                    <i data-lucide="log-out" class="w-5 h-5"></i> {{ __('strings.logout') ?? 'تسجيل الخروج' }}
                </button>
            </form>
        </div>
    </aside>

    {{-- ========================================== --}}
    {{--  المحتوى الرئيسي  --}}
    {{-- ========================================== --}}
    <div class="flex-1 flex flex-col h-screen overflow-hidden relative">
        
        <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-6 z-20">
            
            <button onclick="toggleSidebar()" class="md:hidden p-2 text-slate-500 hover:bg-slate-100 rounded-lg">
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>

            <div class="hidden md:flex items-center bg-slate-100 rounded-xl px-4 py-2 w-96 border border-slate-200 focus-within:ring-2 focus-within:ring-teal-500/20 focus-within:border-teal-500 transition">
                <i data-lucide="search" class="w-4 h-4 text-slate-400"></i>
                <input type="text" placeholder="{{ __('strings.search_placeholder') ?? 'بحث في النظام...' }}" class="bg-transparent border-none focus:outline-none text-sm w-full px-3 text-slate-700">
                <span class="text-xs text-slate-400 font-mono bg-white px-1.5 py-0.5 rounded border border-slate-200">⌘K</span>
            </div>

            <div class="flex items-center gap-4">
                
                <div class="relative group">
                    <button class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-slate-100 text-slate-500 transition">
                        <i data-lucide="globe" class="w-5 h-5"></i>
                    </button>
                    <div class="dropdown-menu absolute top-full right-0 rtl:right-auto rtl:left-0 mt-2 w-32 bg-white rounded-xl shadow-xl border border-slate-100 py-2 z-50">
                        <a href="{{ route('switchLang', 'en') }}" class="flex items-center px-4 py-2 hover:bg-slate-50 text-sm text-slate-600">🇺🇸 English</a>
                        <a href="{{ route('switchLang', 'ar') }}" class="flex items-center px-4 py-2 hover:bg-slate-50 text-sm text-slate-600">🇵🇸 العربية</a>
                    </div>
                </div>

                <button class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-slate-100 text-slate-500 transition relative">
                    <i data-lucide="bell" class="w-5 h-5"></i>
                    <span class="absolute top-2.5 right-2.5 rtl:right-auto rtl:left-2.5 w-2 h-2 bg-red-500 rounded-full border border-white"></span>
                </button>

                <div class="h-8 w-px bg-slate-200 mx-1"></div>

                <div class="flex items-center gap-3">
                    <div class="text-right rtl:text-left hidden sm:block">
                        <p class="text-sm font-bold text-slate-700">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-400">Super Admin</p>
                    </div>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0f766e&color=fff" class="w-10 h-10 rounded-full border-2 border-white shadow-sm">
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 p-6">
            @yield('content')
        </main>
    </div>

    <script src="{{ asset('js/adminNav.js') }}"></script>
    @stack('scripts')
</body>
</html>