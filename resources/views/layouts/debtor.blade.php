<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>payAware - @yield('title')</title>
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
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="{{ asset('css/debtorNav.css') }}">
</head>
<body class="min-h-screen text-slate-800 relative">

    <nav class="fixed top-0 w-full glass z-50 border-b border-slate-200/60 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                
                <div class="flex items-center gap-12">
                    <a href="{{ route('home') }}" class="text-3xl font-bold text-teal-600 font-cursive hover:scale-105 transition transform">payAware</a>
                    
                    <div class="hidden md:flex items-center space-x-1 rtl:space-x-reverse bg-slate-100/50 p-1 rounded-full border border-slate-200">
                        <a href="{{ route('debtor.dashboard') }}" class="px-5 py-2 rounded-full text-sm font-medium transition {{ request()->routeIs('debtor.dashboard') ? 'bg-white text-teal-700 shadow-sm font-bold border border-slate-100' : 'text-slate-500 hover:text-teal-600 hover:bg-white/50' }}">
                            {{ __('strings.dashboard') }}
                        </a>
                        <a href="{{ route('debtor.debts') }}" class="px-5 py-2 rounded-full text-sm font-medium transition {{ request()->routeIs('debtor.debts') ? 'bg-white text-teal-700 shadow-sm font-bold border border-slate-100' : 'text-slate-500 hover:text-teal-600 hover:bg-white/50' }}">
                            {{ __('strings.my_debts') }}
                        </a>
                        <a href="{{ route('debtor.history') }}" class="px-5 py-2 rounded-full text-sm font-medium transition {{ request()->routeIs('debtor.history') ? 'bg-white text-teal-700 shadow-sm font-bold border border-slate-100' : 'text-slate-500 hover:text-teal-600 hover:bg-white/50' }}">
                            {{ __('strings.history_log') }}
                        </a>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    
                    <div class="relative group">
                        <button class="flex items-center justify-center w-10 h-10 rounded-full hover:bg-slate-100 transition text-slate-500 hover:text-teal-600">
                            <i data-lucide="globe" class="w-5 h-5"></i>
                        </button>
                        <div class="dropdown-menu absolute top-full right-0 rtl:right-auto rtl:left-0 mt-2 w-32 bg-white rounded-xl shadow-xl border border-slate-100 py-2 z-50">
                            <a href="{{ route('switchLang', 'en') }}" class="flex items-center px-4 py-2 hover:bg-slate-50 text-sm text-slate-600 hover:text-teal-500"><span class="mr-2 rtl:ml-2 rtl:mr-0">🇺🇸</span> English</a>
                            <a href="{{ route('switchLang', 'ar') }}" class="flex items-center px-4 py-2 hover:bg-slate-50 text-sm text-slate-600 hover:text-teal-500"><span class="mr-2 rtl:ml-2 rtl:mr-0">🇵🇸</span> العربية</a>
                        </div>
                    </div>

                    <a href="{{ route('chat.index') }}" class="relative w-10 h-10 flex items-center justify-center text-slate-500 hover:text-teal-600 hover:bg-slate-100 rounded-full transition {{ request()->routeIs('chat.*') ? 'text-teal-600 bg-slate-100' : '' }}">
                        <i data-lucide="message-circle" class="w-5 h-5"></i>
                        <span class="absolute top-2.5 right-2.5 rtl:right-auto rtl:left-2.5 w-2 h-2 bg-teal-500 rounded-full border-2 border-white animate-pulse"></span>
                    </a>

                    <div class="relative" id="notifications-wrapper">
                        <button onclick="toggleNotifications(event)" class="relative w-10 h-10 flex items-center justify-center text-slate-400 hover:text-teal-600 hover:bg-slate-100 rounded-full transition focus:outline-none">
                            <i data-lucide="bell" class="w-5 h-5"></i>
                            
                            @if(Auth::user()->unreadNotifications->count() > 0)
                                <span class="absolute top-2.5 right-2.5 rtl:right-auto rtl:left-2.5 w-2 h-2 bg-red-500 rounded-full border-2 border-white animate-pulse"></span>
                            @endif
                        </button>

                        <div id="notifications-dropdown" class="hidden absolute top-full right-0 rtl:right-auto rtl:left-0 mt-3 w-80 bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden z-50 origin-top-right transition-all duration-200">
                            
                            <div class="px-4 py-3 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                                <h3 class="text-xs font-bold text-slate-600 uppercase">{{ __('strings.notifications') ?? 'الإشعارات' }}</h3>
                                @if(Auth::user()->unreadNotifications->count() > 0)
                                    <a href="{{ route('debtor.notifications.read_all') }}" class="text-[10px] font-bold text-teal-600 hover:underline">
                                        {{ __('strings.mark_all_read') ?? 'تحديد الكل كمقروء' }}
                                    </a>
                                @endif
                            </div>

                            <div class="max-h-80 overflow-y-auto custom-scroll">
                                @forelse(Auth::user()->notifications as $notification)
                                    <a href="{{ route('debtor.notifications.read', $notification->id) }}" class="block px-4 py-3 hover:bg-slate-50 transition border-b border-slate-50 last:border-0 {{ $notification->read_at ? 'opacity-70' : 'bg-teal-50/10' }}">
                                        <div class="flex gap-3">
                                            {{-- الأيقونة --}}
                                            <div class="shrink-0 mt-1">
                                                @php $type = $notification->data['type'] ?? 'info'; @endphp
                                                @if($type == 'payment')
                                                    <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center border border-emerald-200"><i data-lucide="check-circle" class="w-4 h-4"></i></div>
                                                @elseif($type == 'debt')
                                                    <div class="w-8 h-8 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center border border-rose-200"><i data-lucide="alert-circle" class="w-4 h-4"></i></div>
                                                @else
                                                    <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center border border-slate-200"><i data-lucide="bell" class="w-4 h-4"></i></div>
                                                @endif
                                            </div>
                                            
                                            <div class="flex-1">
                                                <div class="flex justify-between items-start">
                                                    <p class="text-xs font-bold text-slate-800 leading-tight mb-1">
                                                        {{ $notification->data['title'] ?? 'إشعار جديد' }}
                                                    </p>
                                                    @if(!$notification->read_at)
                                                        <span class="w-2 h-2 bg-teal-500 rounded-full mt-1"></span>
                                                    @endif
                                                </div>
                                                <p class="text-[11px] text-slate-500 leading-snug">
                                                    {{ $notification->data['body'] ?? Str::limit($notification->data['message'] ?? '', 60) }}
                                                </p>
                                                <p class="text-[10px] text-slate-400 mt-1 font-medium flex items-center gap-1">
                                                    <i data-lucide="clock" class="w-3 h-3"></i>
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="py-8 text-center">
                                        <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-2 text-slate-300">
                                            <i data-lucide="bell-off" class="w-6 h-6"></i>
                                        </div>
                                        <p class="text-xs text-slate-400">{{ __('strings.no_notifications') ?? 'لا توجد إشعارات حالياً' }}</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="h-6 w-px bg-slate-200 mx-1"></div>

                    {{-- ✅ قائمة الملف الشخصي (تم التعديل لإضافة الـ ID) --}}
                    <div class="relative group">
                        <button class="flex items-center gap-3 pl-2 pr-1 rtl:pr-2 rtl:pl-1 py-1 rounded-full hover:bg-slate-50 border border-transparent hover:border-slate-100 transition">
                            <div class="text-right hidden sm:block rtl:text-left">
                                {{-- الاسم --}}
                                <p class="text-xs font-bold text-slate-700 group-hover:text-teal-700 transition">{{ Auth::user()->name }}</p>
                                
                                {{-- ID الحساب والدور --}}
                                <div class="flex items-center justify-end gap-1.5 mt-0.5">
                                    <span class="text-[10px] bg-slate-100 text-slate-600 px-1.5 py-0.5 rounded font-mono font-bold border border-slate-200" title="Account ID">
                                        #{{ Auth::user()->account_id }}
                                    </span>
                                    <span class="text-slate-300 text-[10px]">|</span>
                                    <span class="text-[10px] text-slate-400">{{ __('strings.debtor_role') }}</span>
                                </div>
                            </div>
                            <img src="{{ Auth::user()->avatar ? asset('storage/'.Auth::user()->avatar) : 'https://cdn0.iconfinder.com/data/icons/user-pictures/100/unknown-512.png' }}" alt="User" class="w-10 h-10 rounded-full bg-white border-2 border-slate-100 shadow-sm group-hover:border-teal-200 transition object-cover">
                            <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 group-hover:text-teal-600 transition duration-300"></i>
                        </button>
                        
                        <div class="dropdown-menu absolute top-full right-0 rtl:right-auto rtl:left-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50">
                            <div class="px-4 py-3 border-b border-slate-50">
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">{{ __('strings.account') }}</p>
                                <p class="text-sm font-bold text-slate-800 truncate">{{ Auth::user()->email }}</p>
                                {{-- عرض الـ ID في القائمة --}}
                                <p class="text-xs font-mono text-teal-600 mt-1">ID: {{ Auth::user()->account_id }}</p>
                            </div>
                            <div class="p-2 space-y-1">
                                <a href="{{ route('debtor.profile') }}" class="flex items-center px-3 py-2 rounded-xl hover:bg-slate-50 text-sm text-slate-600 hover:text-teal-600 transition group/item">
                                    <i data-lucide="user" class="w-4 h-4 mr-3 rtl:ml-3 rtl:mr-0 text-slate-400 group-hover/item:text-teal-500"></i> {{ __('strings.profile') }}
                                </a>
                                <a href="{{ route('debtor.settings') }}" class="flex items-center px-3 py-2 rounded-xl hover:bg-slate-50 text-sm text-slate-600 hover:text-teal-600 transition group/item">
                                    <i data-lucide="settings" class="w-4 h-4 mr-3 rtl:ml-3 rtl:mr-0 text-slate-400 group-hover/item:text-teal-500"></i> {{ __('strings.settings') }}
                                </a>
                            </div>
                            
                            <div class="border-t border-slate-50 mt-1 p-2">
                                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center px-3 py-2 rounded-xl hover:bg-red-50 text-sm text-red-500 transition">
                                        <i data-lucide="log-out" class="w-4 h-4 mr-3 rtl:ml-3 rtl:mr-0"></i> {{ __('strings.logout') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    @yield('content')

    @yield('modals')

   <script src="{{ asset('js/debtorNav.js') }}"></script>    
    @stack('scripts')
</body>
</html>