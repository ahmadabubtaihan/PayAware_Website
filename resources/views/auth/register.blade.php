<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>payAware - {{ __('strings.create_account_title') }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

<link rel="stylesheet" href="{{ asset('css/authStyle.css') }}">
</head>
<body class="min-h-screen flex flex-col md:flex-row bg-white selection:bg-teal-100 overflow-hidden">

    <div class="w-full md:w-1/2 flex flex-col bg-white relative z-20 h-screen shadow-2xl shadow-slate-200/50 border-r border-slate-100">
        
        <div class="absolute top-6 left-6 rtl:left-auto rtl:right-6 z-30">
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-slate-400 hover:text-teal-600 transition-colors py-2 px-3 rounded-lg hover:bg-slate-50 text-sm font-medium group">
                <i data-lucide="arrow-left" class="w-4 h-4 rtl:rotate-180 transition-transform group-hover:-translate-x-1 rtl:group-hover:translate-x-1"></i>
                {{ __('strings.back_home') }}
            </a>
        </div>

        <div class="h-full overflow-y-auto custom-scroll flex flex-col items-center justify-center py-10 px-6 md:px-12 lg:px-20">
            
            <div class="w-full max-w-md space-y-8 animate-fade-in mt-12 md:mt-0">
                
                <div class="text-center md:text-left rtl:md:text-right">
                    <div class="md:hidden mb-4 inline-block">
                         <span class="text-3xl font-bold text-teal-500 font-cursive">payAware</span>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-2 tracking-tight">{{ __('strings.create_account_title') }}</h1>
                    <p class="text-slate-500">
                        {{ __('strings.already_have_account') }} 
                        <a href="{{ route('login') }}" class="text-teal-600 font-bold hover:text-teal-700 hover:underline transition decoration-2 underline-offset-2">{{ __('strings.login_btn') }}</a>
                    </p>
                </div>

                <div class="p-1.5 bg-slate-100/80 rounded-2xl flex relative animate-fade-in delay-100 border border-slate-200">
                    <button type="button" id="btn-debit" onclick="setRole('debtor')" class="flex-1 flex items-center justify-center gap-2 py-3 rounded-xl text-sm font-bold transition-all duration-300 shadow-sm bg-white text-teal-700 ring-1 ring-black/5">
                        <i data-lucide="user" class="w-4 h-4"></i>
                        {{ __('strings.reg_debit') }}
                    </button>
                    <button type="button" id="btn-creditor" onclick="setRole('creditor')" class="flex-1 flex items-center justify-center gap-2 py-3 rounded-xl text-sm font-bold text-slate-500 hover:text-slate-700 hover:bg-white/50 transition-all duration-300">
                        <i data-lucide="briefcase" class="w-4 h-4"></i>
                        {{ __('strings.reg_creditor') }}
                    </button>
                </div>

                <form method="POST" action="{{ route('register.submit') }}" class="space-y-5 animate-fade-in delay-200">
                    @csrf
                    <input type="hidden" name="role" id="role_input" value="debtor">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-700 uppercase tracking-wider ml-1 rtl:mr-1 rtl:ml-0">{{ __('strings.full_name') }} <span class="text-red-500">*</span></label>
                            <div class="relative group input-group">
                                <div class="absolute inset-y-0 left-0 rtl:left-auto rtl:right-0 pl-3 rtl:pr-3 flex items-center pointer-events-none">
                                    <i data-lucide="user" class="w-5 h-5 text-slate-400 transition-colors"></i>
                                </div>
                                <input type="text" name="name" value="{{ old('name') }}" required class="w-full bg-slate-50/50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-teal-500 focus:border-teal-500 block pl-10 pr-3 rtl:pl-3 rtl:pr-10 py-3 transition-all outline-none" placeholder="Ahmad Ali">
                            </div>
                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-700 uppercase tracking-wider ml-1 rtl:mr-1 rtl:ml-0">{{ __('strings.email_label') }} <span class="text-red-500">*</span></label>
                            <div class="relative group input-group">
                                <div class="absolute inset-y-0 left-0 rtl:left-auto rtl:right-0 pl-3 rtl:pr-3 flex items-center pointer-events-none">
                                    <i data-lucide="mail" class="w-5 h-5 text-slate-400 transition-colors"></i>
                                </div>
                                <input type="email" name="email" value="{{ old('email') }}" required class="w-full bg-slate-50/50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-teal-500 focus:border-teal-500 block pl-10 pr-3 rtl:pl-3 rtl:pr-10 py-3 transition-all outline-none" placeholder="name@mail.com">
                            </div>
                            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div id="creditor-fields" class="grid grid-cols-1 md:grid-cols-2 gap-5 hidden">
                        <div class="space-y-1.5 animate-fade-in">
                            <label class="text-xs font-bold text-slate-700 uppercase tracking-wider ml-1 rtl:mr-1 rtl:ml-0">{{ __('strings.owner_name') }} <span class="text-red-500">*</span></label>
                            <div class="relative group input-group">
                                <div class="absolute inset-y-0 left-0 rtl:left-auto rtl:right-0 pl-3 rtl:pr-3 flex items-center pointer-events-none">
                                    <i data-lucide="crown" class="w-5 h-5 text-slate-400 transition-colors"></i>
                                </div>
                                <input type="text" name="owner_name" value="{{ old('owner_name') }}" class="w-full bg-slate-50/50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-teal-500 focus:border-teal-500 block pl-10 pr-3 rtl:pl-3 rtl:pr-10 py-3 transition-all outline-none" placeholder="Owner Name">
                            </div>
                            @error('owner_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="space-y-1.5 animate-fade-in">
                            <label class="text-xs font-bold text-slate-700 uppercase tracking-wider ml-1 rtl:mr-1 rtl:ml-0">{{ __('strings.company_name') }} <span class="text-red-500">*</span></label>
                            <div class="relative group input-group">
                                <div class="absolute inset-y-0 left-0 rtl:left-auto rtl:right-0 pl-3 rtl:pr-3 flex items-center pointer-events-none">
                                    <i data-lucide="building-2" class="w-5 h-5 text-slate-400 transition-colors"></i>
                                </div>
                                <input type="text" name="company_name" value="{{ old('company_name') }}" class="w-full bg-slate-50/50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-teal-500 focus:border-teal-500 block pl-10 pr-3 rtl:pl-3 rtl:pr-10 py-3 transition-all outline-none" placeholder="Company LTD">
                            </div>
                            @error('company_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-700 uppercase tracking-wider ml-1 rtl:mr-1 rtl:ml-0">{{ __('strings.phone_label') }} <span class="text-red-500">*</span></label>
                            <div class="flex relative group input-group rounded-xl shadow-sm" dir="ltr">
                                <select class="bg-slate-50 border border-r-0 border-slate-200 text-slate-700 text-sm rounded-l-xl focus:ring-teal-500 focus:border-teal-500 block w-20 p-2.5 outline-none font-bold">
                                    <option value="+972">🇵🇸 +972</option>
                                    <option value="+1">🇺🇸 +1</option>
                                </select>
                                <input type="tel" name="phone" value="{{ old('phone') }}" required class="w-full bg-slate-50/50 border border-l-0 border-slate-200 text-slate-900 text-sm rounded-r-xl focus:ring-teal-500 focus:border-teal-500 block p-2.5 outline-none transition-all" placeholder="59xxxxxxx">
                            </div>
                            @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-700 uppercase tracking-wider ml-1 rtl:mr-1 rtl:ml-0">{{ __('strings.address_label') }} <span class="text-red-500">*</span></label>
                            <div class="relative group input-group">
                                <div class="absolute inset-y-0 left-0 rtl:left-auto rtl:right-0 pl-3 rtl:pr-3 flex items-center pointer-events-none">
                                    <i data-lucide="map-pin" class="w-5 h-5 text-slate-400 transition-colors"></i>
                                </div>
                                <input type="text" name="address" value="{{ old('address') }}" required class="w-full bg-slate-50/50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-teal-500 focus:border-teal-500 block pl-10 pr-3 rtl:pl-3 rtl:pr-10 py-3 transition-all outline-none" placeholder="City, Country">
                            </div>
                            @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-700 uppercase tracking-wider ml-1 rtl:mr-1 rtl:ml-0">{{ __('strings.password_label') }} <span class="text-red-500">*</span></label>
                            <div class="relative group input-group">
                                <div class="absolute inset-y-0 left-0 rtl:left-auto rtl:right-0 pl-3 rtl:pr-3 flex items-center pointer-events-none">
                                    <i data-lucide="lock" class="w-5 h-5 text-slate-400 transition-colors"></i>
                                </div>
                                <input type="password" name="password" required class="w-full bg-slate-50/50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-teal-500 focus:border-teal-500 block pl-10 pr-3 rtl:pl-3 rtl:pr-10 py-3 transition-all outline-none" placeholder="••••••••">
                            </div>
                            @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-700 uppercase tracking-wider ml-1 rtl:mr-1 rtl:ml-0">{{ __('strings.confirm_password') }} <span class="text-red-500">*</span></label>
                            <div class="relative group input-group">
                                <div class="absolute inset-y-0 left-0 rtl:left-auto rtl:right-0 pl-3 rtl:pr-3 flex items-center pointer-events-none">
                                    <i data-lucide="check-circle-2" class="w-5 h-5 text-slate-400 transition-colors"></i>
                                </div>
                                <input type="password" name="password_confirmation" required class="w-full bg-slate-50/50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-teal-500 focus:border-teal-500 block pl-10 pr-3 rtl:pl-3 rtl:pr-10 py-3 transition-all outline-none" placeholder="••••••••">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-teal-500 to-teal-700 hover:from-teal-600 hover:to-teal-800 text-white font-bold py-4 rounded-xl shadow-lg shadow-teal-500/30 transition-all transform hover:-translate-y-1 active:scale-95 text-base flex items-center justify-center gap-2 group mt-6">
                        {{ __('strings.create_acc_btn') }}
                        <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 rtl:group-hover:-translate-x-1 rtl:rotate-180 transition-transform"></i>
                    </button>
                </form>

                <div class="relative animate-fade-in delay-300">
                    <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-200"></div></div>
                    <div class="relative flex justify-center text-xs uppercase">
                        <span class="bg-white px-3 text-slate-400 font-bold tracking-wide">{{ __('strings.or_register') }}</span>
                    </div>
                </div>

                <button class="w-full flex items-center justify-center gap-3 bg-white hover:bg-slate-50 text-slate-700 font-semibold py-3.5 px-4 rounded-xl border border-slate-200 transition-all duration-300 shadow-sm hover:shadow-md group animate-fade-in delay-300">
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    {{ __('strings.register_google') }}
                </button>
            </div>
        </div>
    </div>

    <div class="hidden md:flex w-1/2 bg-slate-50 relative items-center justify-center p-12 overflow-hidden border-l border-slate-100" dir="ltr">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-teal-100/40 via-slate-50 to-white"></div>
        <div class="absolute inset-0 opacity-30 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] bg-repeat"></div>
        
        <div class="absolute top-20 right-20 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-[90px] opacity-30 animate-float"></div>
        <div class="absolute bottom-20 left-20 w-72 h-72 bg-teal-300 rounded-full mix-blend-multiply filter blur-[90px] opacity-30 animate-float delay-300"></div>

        <div class="relative z-10 w-full max-w-lg text-center backdrop-blur-3xl">
            
            <div class="bg-white/60 backdrop-blur-xl rounded-[2.5rem] p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white/50 relative mb-12 animate-fade-in">
                <div class="grid grid-cols-2 gap-6">
                    <div class="bg-white/80 p-5 rounded-2xl border border-white shadow-sm flex flex-col items-center justify-center group hover:scale-105 transition-transform duration-500">
                        <div class="relative w-20 h-20 mb-2">
                             <svg viewBox="0 0 36 36" class="w-full h-full transform -rotate-90">
                                <path class="text-slate-100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3" />
                                <path class="text-teal-500" stroke-dasharray="75, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" />
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center font-bold text-slate-700">75%</div>
                        </div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ __('strings.activity') }}</span>
                    </div>
                    
                    <div class="bg-white/80 p-5 rounded-2xl border border-white shadow-sm flex flex-col justify-between group hover:scale-105 transition-transform duration-500 delay-100">
                        <div class="flex items-center gap-3 mb-2">
                           <div class="p-2 bg-indigo-50 rounded-lg text-indigo-500"><i data-lucide="users" class="w-4 h-4"></i></div>
                           <span class="text-lg font-bold text-slate-800">2.4k</span>
                        </div>
                        <div class="space-y-2">
                            <div class="flex -space-x-2 overflow-hidden py-1">
                                <img class="inline-block h-6 w-6 rounded-full ring-2 ring-white" src="https://api.dicebear.com/7.x/avataaars/svg?seed=1" alt=""/>
                                <img class="inline-block h-6 w-6 rounded-full ring-2 ring-white" src="https://api.dicebear.com/7.x/avataaars/svg?seed=2" alt=""/>
                                <img class="inline-block h-6 w-6 rounded-full ring-2 ring-white" src="https://api.dicebear.com/7.x/avataaars/svg?seed=3" alt=""/>
                            </div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block">{{ __('strings.users') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-5xl font-bold text-teal-600 font-cursive mb-4 drop-shadow-sm animate-fade-in delay-200">
                payAware
            </div>
            
            <h2 class="text-3xl font-extrabold text-slate-800 mb-4 leading-tight animate-fade-in delay-200">
                {{ __('strings.join_revolution') }}
            </h2>
            
            <p class="text-slate-500 text-lg max-w-sm mx-auto leading-relaxed animate-fade-in delay-300">
                {{ __('strings.join_desc') }}
            </p>
        </div>
    </div>

<script src="{{ asset('js/authLog.js') }}"></script>
</body>
</html>