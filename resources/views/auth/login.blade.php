<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>payAware - {{ __('strings.login_title') }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

<link rel="stylesheet" href="{{ asset('css/authStyle.css') }}">
</head>
<body class="min-h-screen flex flex-col md:flex-row bg-white selection:bg-teal-100 overflow-hidden">

    <div class="w-full md:w-1/2 flex flex-col justify-center p-8 lg:p-20 bg-white relative z-10 border-r border-slate-100 h-screen">
        
        <a href="{{ route('home') }}" class="absolute top-6 left-6 rtl:left-auto rtl:right-6 flex items-center gap-2 text-slate-400 hover:text-teal-500 transition text-sm font-medium group">
            <i data-lucide="arrow-left" class="w-4 h-4 rtl:rotate-180 transition group-hover:-translate-x-1 rtl:group-hover:translate-x-1"></i>
            {{ __('strings.back_home') }}
        </a>

        <div class="w-full max-w-md mx-auto space-y-8 mt-4 md:mt-0 animate-fade-in">
            <div class="text-center md:text-left rtl:md:text-right">
                <div class="md:hidden mb-4 inline-block">
                     <span class="text-3xl font-bold text-teal-500 font-cursive">payAware</span>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-slate-900 mb-3 tracking-tight">{{ __('strings.login_title') }}</h1>
                <p class="text-slate-500">
                    {{ __('strings.no_account') }} 
                    <a href="{{ route('register') }}" class="text-teal-500 font-bold hover:text-teal-600 hover:underline transition">{{ __('strings.sign_up') }}</a>
                </p>
            </div>

            @if (session('success'))
                <div class="bg-green-50 text-green-600 p-4 rounded-xl text-sm font-medium flex items-center gap-2 border border-green-100 animate-fade-in">
                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->has('email'))
                <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm font-medium flex items-center gap-2 border border-red-100 animate-fade-in">
                    <i data-lucide="alert-circle" class="w-5 h-5"></i>
                    {{ $errors->first('email') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}" class="space-y-6">
                @csrf <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1 rtl:mr-1 rtl:ml-0">{{ __('strings.email_label') }}</label>
                    <div class="relative group input-group bg-slate-50 border border-slate-200 rounded-xl transition-all overflow-hidden flex items-center">
                         <div class="pl-4 pr-2 rtl:pl-2 rtl:pr-4">
                             <i data-lucide="mail" class="w-5 h-5 text-slate-400 transition-colors"></i>
                         </div>
                         <input type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full bg-transparent border-none text-slate-900 text-sm py-3.5 px-1 focus:ring-0 outline-none placeholder-slate-400 font-medium" placeholder="{{ __('strings.email_placeholder') }}" />
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1 rtl:mr-1 rtl:ml-0">{{ __('strings.password_label') }}</label>
                    <div class="relative group input-group bg-slate-50 border border-slate-200 rounded-xl transition-all overflow-hidden flex items-center">
                        <div class="pl-4 pr-2 rtl:pl-2 rtl:pr-4">
                            <i data-lucide="lock" class="w-5 h-5 text-slate-400 transition-colors"></i>
                        </div>
                        <input type="password" name="password" required class="w-full bg-transparent border-none text-slate-900 text-sm py-3.5 px-1 focus:ring-0 outline-none placeholder-slate-400 font-medium" placeholder="••••••••" />
                    </div>
                </div>

                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center space-x-2 rtl:space-x-reverse cursor-pointer group select-none">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-teal-500 focus:ring-teal-400 cursor-pointer" />
                        <span class="text-slate-500 font-medium group-hover:text-slate-700 transition">{{ __('strings.remember_me') }}</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-slate-400 font-medium hover:text-teal-500 transition">{{ __('strings.forgot_password') }}</a>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-teal-400 to-teal-600 hover:from-teal-500 hover:to-teal-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-teal-200 transition transform hover:-translate-y-1 text-lg mt-2 flex items-center justify-center gap-2 group">
                    {{ __('strings.login_btn') }}
                    <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 rtl:group-hover:-translate-x-1 rtl:rotate-180 transition"></i>
                </button>
            </form>

            <div class="relative py-2">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-slate-100"></div>
                </div>
                <div class="relative flex justify-center text-xs uppercase">
                    <span class="bg-white px-2 text-slate-400 font-medium">{{ __('strings.or_continue') }}</span>
                </div>
            </div>

            <button class="w-full flex items-center justify-center gap-3 bg-white hover:bg-slate-50 text-slate-600 font-semibold py-3.5 px-4 rounded-xl border border-slate-200 transition duration-300 shadow-sm hover:shadow-md group">
                <svg class="w-5 h-5 group-hover:scale-110 transition" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                {{ __('strings.login_google') }}
            </button>
        </div>
    </div>

    <div class="hidden md:flex w-1/2 bg-[#F8FBFF] relative items-center justify-center p-12 overflow-hidden border-l border-slate-50" dir="ltr">
        <div class="absolute inset-0 bg-gradient-to-br from-slate-50 via-white to-teal-50/30"></div>
        <div class="absolute top-1/4 right-10 w-72 h-72 bg-teal-200 rounded-full mix-blend-multiply filter blur-[80px] opacity-40 animate-pulse"></div>
        <div class="absolute bottom-1/4 left-10 w-72 h-72 bg-indigo-200 rounded-full mix-blend-multiply filter blur-[80px] opacity-40 animate-pulse" style="animation-delay: 2s"></div>

        <div class="relative z-10 w-full max-w-lg text-center">
            
            <div class="bg-white/90 backdrop-blur-sm rounded-[2.5rem] p-6 shadow-2xl shadow-slate-200/80 border border-white animate-float relative mb-10">
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-slate-50 p-4 rounded-[1.5rem] border border-slate-100 shadow-sm">
                        <h3 class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2 text-left">{{ __('strings.sessions') }}</h3>
                        <div class="flex justify-center my-2">
                             <div class="w-16 h-16 rounded-full border-8 border-teal-400 border-t-teal-100 animate-spin"></div>
                        </div>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-[1.5rem] border border-slate-100 shadow-sm flex flex-col justify-between">
                        <div class="flex justify-between items-start mb-1">
                           <h3 class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">{{ __('strings.growth') }}</h3>
                           <span class="text-[9px] bg-green-100 text-green-600 px-1.5 py-0.5 rounded font-bold">+15%</span>
                        </div>
                        <div class="h-12 bg-slate-200/50 rounded-lg mt-2 w-full"></div>
                    </div>
                </div>
            </div>

            <div class="text-4xl font-bold text-teal-500 font-cursive mb-4 drop-shadow-sm">
                payAware
            </div>
            
            <h2 class="text-2xl font-bold text-slate-800 mb-3 leading-tight">
                {{ __('strings.manage_debts_title') }} <br /> {{ __('strings.pay_digitally') }} <span class="text-teal-500">{{ __('strings.Digitally') }}</span>
            </h2>
            
            <p class="text-slate-500 text-sm max-w-sm mx-auto leading-relaxed mb-8">
                {{ __('strings.app_desc_short') }}
            </p>
        </div>
    </div>

<script src="{{ asset('js/authLog.js') }}"></script>
</body>
</html>