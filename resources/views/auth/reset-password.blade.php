<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>payAware - {{ __('strings.reset_title') }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

<link rel="stylesheet" href="{{ asset('css/authStyle.css') }}">
</head>
<body class="min-h-screen flex flex-col md:flex-row bg-white selection:bg-teal-100 overflow-hidden">

    <div class="w-full md:w-1/2 flex flex-col justify-center p-8 lg:p-20 bg-white relative z-10 border-r border-slate-100 h-screen">
        
        <div class="w-full max-w-md mx-auto space-y-8 animate-fade-in">
            
            <a href="#" class="inline-flex items-center text-sm font-medium text-slate-400 hover:text-teal-600 transition mb-4 group">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-1 rtl:ml-1 rtl:mr-0 rtl:rotate-180 group-hover:-translate-x-1 rtl:group-hover:translate-x-1 transition-transform"></i>
                {{ __('strings.back_to_login') }}
            </a>

            <div class="text-center md:text-left rtl:md:text-right">
                <div class="w-14 h-14 bg-teal-50 rounded-2xl flex items-center justify-center mb-6 mx-auto md:mx-0 rtl:md:mx-0 text-teal-600 shadow-sm">
                    <i data-lucide="lock-keyhole" class="w-7 h-7"></i>
                </div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-3 tracking-tight">{{ __('strings.reset_title') }}</h1>
                <p class="text-slate-500 leading-relaxed text-lg">
                    {{ __('strings.reset_desc') }}
                </p>
            </div>

            <form class="space-y-6">
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-700 uppercase tracking-wider ml-1 rtl:mr-1 rtl:ml-0">{{ __('strings.new_password_label') }} <span class="text-red-500">*</span></label>
                    <div class="relative group input-group bg-slate-50 border border-slate-200 rounded-xl transition-all overflow-hidden flex items-center">
                         <div class="pl-3 pr-2 rtl:pl-2 rtl:pr-3">
                             <i data-lucide="lock" class="w-5 h-5 text-slate-400 transition-colors"></i>
                         </div>
                         <input type="password" class="w-full bg-transparent border-none text-slate-900 text-sm py-3 px-1 focus:ring-0 outline-none placeholder-slate-400" placeholder="{{ __('strings.new_password_placeholder') }}" />
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-700 uppercase tracking-wider ml-1 rtl:mr-1 rtl:ml-0">{{ __('strings.confirm_pass_reset_label') }} <span class="text-red-500">*</span></label>
                    <div class="relative group input-group bg-slate-50 border border-slate-200 rounded-xl transition-all overflow-hidden flex items-center">
                         <div class="pl-3 pr-2 rtl:pl-2 rtl:pr-3">
                             <i data-lucide="check-circle-2" class="w-5 h-5 text-slate-400 transition-colors"></i>
                         </div>
                         <input type="password" class="w-full bg-transparent border-none text-slate-900 text-sm py-3 px-1 focus:ring-0 outline-none placeholder-slate-400" placeholder="{{ __('strings.confirm_pass_placeholder') }}" />
                    </div>
                </div>

                <button class="w-full bg-gradient-to-r from-teal-500 to-teal-700 hover:from-teal-600 hover:to-teal-800 text-white font-bold py-4 rounded-xl shadow-lg shadow-teal-500/30 transition-all transform hover:-translate-y-1 active:scale-95 text-base flex items-center justify-center gap-2 group">
                    {{ __('strings.reset_btn') }}
                    <i data-lucide="check" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="hidden md:flex w-1/2 bg-slate-50 relative items-center justify-center p-12 overflow-hidden border-l border-slate-100" dir="ltr">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-teal-100/40 via-slate-50 to-white"></div>
        <div class="absolute inset-0 opacity-30 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] bg-repeat"></div>
        
        <div class="absolute top-20 right-20 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-[90px] opacity-30 animate-float"></div>
        <div class="absolute bottom-20 left-20 w-72 h-72 bg-teal-300 rounded-full mix-blend-multiply filter blur-[90px] opacity-30 animate-float" style="animation-delay: 2s"></div>

        <div class="relative z-10 w-full max-w-lg text-center backdrop-blur-3xl">
            
            <div class="bg-white/60 backdrop-blur-xl rounded-[2.5rem] p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white/50 relative mb-12 animate-fade-in">
                
                <div class="absolute top-0 left-0 transform -translate-x-1/3 -translate-y-1/3 bg-white p-3 rounded-2xl shadow-lg border border-white/50 z-20 animate-float">
                     <div class="w-12 h-12 bg-indigo-50 rounded-full flex items-center justify-center text-indigo-500">
                         <i data-lucide="user-check" class="w-6 h-6"></i>
                     </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="bg-white/80 p-5 rounded-2xl border border-white shadow-sm flex flex-col items-center justify-center group hover:scale-105 transition-transform duration-500">
                        <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-3 text-left w-full">{{ __('strings.access') }}</h3>
                        <div class="relative w-20 h-20 flex items-center justify-center mb-2">
                            <div class="w-full h-full rounded-full border-4 border-slate-100"></div>
                            <div class="absolute w-full h-full rounded-full border-4 border-teal-500 border-l-transparent transform rotate-45"></div>
                            <div class="absolute text-slate-400">
                                <i data-lucide="fingerprint" class="w-8 h-8"></i>
                            </div>
                        </div>
                        <div class="text-[10px] text-slate-500 font-bold mt-1 uppercase">{{ __('strings.authentication') }}</div>
                    </div>

                    <div class="bg-white/80 p-5 rounded-2xl border border-white shadow-sm flex flex-col justify-between group hover:scale-105 transition-transform duration-500 delay-100">
                        <div class="flex justify-between items-start mb-1">
                           <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">{{ __('strings.safety') }}</h3>
                           <i data-lucide="shield" class="w-4 h-4 text-green-500"></i>
                        </div>
                        <div class="flex-1 flex flex-col items-center justify-center gap-2 py-2">
                            <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full w-full bg-green-400 rounded-full"></div>
                            </div>
                            <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden opacity-50">
                                <div class="h-full w-3/4 bg-green-400 rounded-full"></div>
                            </div>
                            <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden opacity-30">
                                <div class="h-full w-1/2 bg-green-400 rounded-full"></div>
                            </div>
                        </div>
                        <div class="text-center">
                            <p class="text-[10px] text-slate-500 font-bold uppercase">{{ __('strings.strong_pass') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-5xl font-bold text-teal-600 font-cursive mb-4 drop-shadow-sm animate-fade-in delay-100">
                payAware
            </div>
            
            <h2 class="text-3xl font-extrabold text-slate-800 mb-4 leading-tight animate-fade-in delay-200">
                {{ __('strings.secure_future') }} <br /> <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-500 to-teal-700">{{ __('strings.financial_future') }}</span>
            </h2>
            
            <p class="text-slate-500 text-lg max-w-sm mx-auto leading-relaxed animate-fade-in delay-300">
                {{ __('strings.security_priority') }}
            </p>
        </div>
    </div>

<script src="{{ asset('js/authLog.js') }}"></script>
</body>
</html>