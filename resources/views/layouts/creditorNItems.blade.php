<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'payAware')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="{{ asset('css/creditorNav.css') }}">
</head>
<body class="min-h-screen text-slate-800 relative">

    <nav class="fixed top-0 w-full glass z-50 border-b border-slate-200/60 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                                <div class="flex items-center gap-12">
                    <a href="{{ route('creditor.dashboard') }}" class="text-3xl font-bold text-teal-600 font-cursive hover:scale-105 transition transform">payAware</a>
                    
                    <div class="hidden md:flex items-center space-x-1 bg-slate-100/50 p-1 rounded-full border border-slate-200 rtl:space-x-reverse">
                        <a href="{{ route('creditor.dashboard') }}" class="px-5 py-2 rounded-full {{ Route::is('creditor.dashboard') ? 'bg-white text-teal-700 shadow-sm border border-slate-100' : 'text-slate-500 hover:text-teal-600 hover:bg-white/50' }} text-sm font-bold transition">
                            {{ __('strings.dashboard') }}
                        </a>
                        <a href="{{ route('creditor.debtors') }}" class="px-5 py-2 rounded-full {{ Route::is('creditor.debtors') ? 'bg-white text-teal-700 shadow-sm border border-slate-100' : 'text-slate-500 hover:text-teal-600 hover:bg-white/50' }} text-sm font-medium transition">
                            {{ __('strings.debtors') }}
                        </a>
                        <a href="{{ route('creditor.reports') }}" class="px-5 py-2 rounded-full {{ Route::is('creditor.reports') ? 'bg-white text-teal-700 shadow-sm border border-slate-100' : 'text-slate-500 hover:text-teal-600 hover:bg-white/50' }} text-sm font-medium transition">
                            {{ __('strings.reports') }}
                        </a>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    
                    <div class="relative group">
                        <button class="flex items-center justify-center w-10 h-10 rounded-full hover:bg-slate-100 transition text-slate-500 hover:text-teal-600">
                            <i data-lucide="globe" class="w-5 h-5"></i>
                        </button>
                        <div class="dropdown-menu absolute top-full right-0 rtl:right-auto rtl:left-0 mt-2 w-32 bg-white rounded-xl shadow-xl border border-slate-100 py-2 z-50">
                            <a href="{{ route('switchLang', 'en') }}" class="flex items-center px-4 py-2 hover:bg-slate-50 text-sm text-slate-600 hover:text-teal-500">
                                <span class="mr-2">🇺🇸</span> English
                            </a>
                            <a href="{{ route('switchLang', 'ar') }}" class="flex items-center px-4 py-2 hover:bg-slate-50 text-sm text-slate-600 hover:text-teal-500">
                                <span class="mr-2">🇸🇦</span> العربية
                            </a>
                        </div>
                    </div>

<a href="{{ route('chat.index') }}" class="relative w-10 h-10 flex items-center justify-center text-slate-500 hover:text-teal-600 transition shrink-0 rounded-full hover:bg-slate-100">
    <i data-lucide="message-circle" class="w-5 h-5"></i>
    {{-- <span class="absolute top-2 right-2 w-2 h-2 bg-teal-500 rounded-full border border-white"></span> --}}
</a>
                    @php
                        $notifications = Auth::user() ? Auth::user()->unreadNotifications : collect();
                        $hasNotifications = $notifications->count() > 0;
                    @endphp

                    <div class="relative group">
                        <button class="relative w-10 h-10 flex items-center justify-center text-slate-500 hover:text-teal-600 transition shrink-0 rounded-full hover:bg-slate-100">
                            <i data-lucide="bell" class="w-5 h-5"></i>
                            @if($hasNotifications)
                                <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-red-500 rounded-full border-2 border-white animate-pulse"></span>
                            @endif
                        </button>

                        <div class="dropdown-menu absolute top-full right-0 rtl:right-auto rtl:left-0 mt-2 w-80 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50 overflow-hidden">
                            {{-- Header --}}
                            <div class="px-4 py-3 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                                <p class="text-xs font-bold text-slate-700 uppercase tracking-wider">{{ __('strings.notifications') }}</p>
                                @if($hasNotifications)
                                    <a href="{{ route('creditor.notifications.read') }}" class="text-[10px] font-bold text-teal-600 hover:underline">
                                        {{ __('strings.mark_all_read') }}
                                    </a>
                                @endif
                            </div>

                            {{-- List --}}
                            <div class="max-h-64 overflow-y-auto custom-scroll">
                                @forelse($notifications as $notification)
                                    <a href="{{ $notification->data['url'] ?? '#' }}" class="flex items-start gap-3 px-4 py-3 hover:bg-slate-50 transition border-b border-slate-50 last:border-0 group/item">
                                        <div class="mt-1 p-1.5 rounded-full bg-slate-100 group-hover/item:bg-white border border-slate-100 group-hover/item:shadow-sm transition">
                                            <i data-lucide="{{ $notification->data['icon'] ?? 'bell' }}" class="w-4 h-4 {{ $notification->data['color'] ?? 'text-slate-500' }}"></i>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="text-sm font-bold text-slate-800">{{ $notification->data['title'] }}</h4>
                                            <p class="text-xs text-slate-500 mt-0.5 line-clamp-2">{{ $notification->data['message'] }}</p>
                                            <span class="text-[10px] text-slate-400 font-medium mt-1 block">{{ $notification->created_at->diffForHumans() }}</span>
                                        </div>
                                    </a>
                                @empty
                                    <div class="py-8 text-center">
                                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-slate-50 text-slate-300 mb-2">
                                            <i data-lucide="bell-off" class="w-6 h-6"></i>
                                        </div>
                                        <p class="text-xs text-slate-400 font-medium">{{ __('strings.no_notifications') }}</p>
                                    </div>
                                @endforelse
                            </div>
                            
                            {{-- Footer --}}
                            @if($notifications->count() > 5)
                            <div class="border-t border-slate-50 p-2 text-center">
                                <a href="#" class="text-xs font-bold text-slate-500 hover:text-teal-600 transition">{{ __('strings.view_all') }}</a>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="h-6 w-px bg-slate-200 mx-1"></div>

@auth
                    <div class="relative group">
                        <button class="flex items-center gap-3 pl-2 pr-1 py-1 rounded-full hover:bg-slate-50 border border-transparent hover:border-slate-100 transition">
                            <div class="text-right rtl:text-left hidden sm:block">
                                <p class="text-xs font-bold text-slate-700 group-hover:text-teal-700 transition">
                                    {{ Auth::user()->name }}
                                </p>
                                
                                <div class="flex items-center justify-end gap-1.5 mt-0.5">
                                    <span class="text-[10px] bg-slate-100 text-slate-600 px-1.5 py-0.5 rounded font-mono font-bold border border-slate-200" title="Account ID">
                                        #{{ Auth::user()->account_id }}
                                    </span>
                                    
                                    <span class="text-slate-300 text-[10px]">|</span>

                                    <span class="text-[10px] text-slate-400 truncate max-w-[80px]">
                                        {{ Auth::user()->company_name ?? Auth::user()->job_title ?? __('strings.creditor') }}
                                    </span>
                                </div>
                            </div>
                            
                            <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://api.dicebear.com/7.x/initials/svg?seed=' . Auth::user()->name }}" 
                                 alt="{{ Auth::user()->name }}" 
                                 class="w-10 h-10 rounded-full bg-white border-2 border-slate-100 shadow-sm group-hover:border-teal-200 transition">
                            
                            <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 group-hover:text-teal-600 transition duration-300"></i>
                        </button>
                        
                        <div class="dropdown-menu absolute top-full right-0 rtl:right-auto rtl:left-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50">
                            <div class="px-4 py-3 border-b border-slate-50">
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">{{ __('strings.account') }}</p>
                                <p class="text-sm font-bold text-slate-800 truncate">{{ Auth::user()->email }}</p>
                                <p class="text-xs font-mono text-teal-600 mt-1">ID: {{ Auth::user()->account_id }}</p>
                            </div>
                            <div class="p-2 space-y-1">
                                <a href="{{ route('creditor.profile') }}" class="flex items-center px-3 py-2 rounded-xl hover:bg-slate-50 text-sm text-slate-600 hover:text-teal-600 transition group/item">
                                    <i data-lucide="user" class="w-4 h-4 mr-3 rtl:ml-3 rtl:mr-0 text-slate-400 group-hover/item:text-teal-500"></i> {{ __('strings.profile') }}
                                </a>
                                <a href="{{ route('creditor.settings.index') }}" class="flex items-center px-3 py-2 rounded-xl hover:bg-slate-50 text-sm text-slate-600 hover:text-teal-600 transition group/item">
                                    <i data-lucide="settings" class="w-4 h-4 mr-3 rtl:ml-3 rtl:mr-0 text-slate-400 group-hover/item:text-teal-500"></i> {{ __('strings.settings') }}
                                </a>
                            </div>
                            <div class="border-t border-slate-50 mt-1 p-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex w-full items-center px-3 py-2 rounded-xl hover:bg-red-50 text-sm text-red-500 transition">
                                        <i data-lucide="log-out" class="w-4 h-4 mr-3 rtl:ml-3 rtl:mr-0"></i> {{ __('strings.logout') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endauth

                </div>
            </div>
        </div>
    </nav>

    {{-- Chat Widget --}}
    <div id="chat-widget" class="fixed bottom-6 right-6 z-50 chat-widget">
        <div class="bg-white w-80 sm:w-96 h-[32rem] rounded-3xl shadow-2xl shadow-slate-300 border border-slate-100 flex flex-col overflow-hidden">
             </div>
    </div>

    @yield('content')

    <script src="{{ asset('js/creditorNav.js') }}" defer></script>

    @stack('scripts')
</body>
</html>