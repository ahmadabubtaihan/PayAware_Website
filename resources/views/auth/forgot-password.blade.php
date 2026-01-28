<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>payAware - {{ __('strings.forgot_title') }}</title>
    
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
                    <i data-lucide="key-round" class="w-7 h-7"></i>
                </div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-3 tracking-tight">{{ __('strings.forgot_title') }}</h1>
                <p class="text-slate-500 leading-relaxed text-lg">
                    {{ __('strings.forgot_desc') }}
                </p>
            </div>

            <form class="space-y-6">
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-700 uppercase tracking-wider ml-1 rtl:mr-1 rtl:ml-0">{{ __('strings.email_label') }} <span class="text-red-500">*</span></label>
                    <div class="relative group input-group bg-slate-50 border border-slate-200 rounded-xl transition-all overflow-hidden flex items-center">
                         <div class="pl-3 pr-2 rtl:pl-2 rtl:pr-3">
                             <i data-lucide="mail" class="w-5 h-5 text-slate-400 transition-colors"></i>
                         </div>
                         <input type="email" class="w-full bg-transparent border-none text-slate-900 text-sm py-3 px-1 focus:ring-0 outline-none placeholder-slate-400" placeholder="{{ __('strings.email_placeholder') }}" />
                    </div>
                </div>

                <button class="w-full bg-gradient-to-r from-teal-500 to-teal-700 hover:from-teal-600 hover:to-teal-800 text-white font-bold py-4 rounded-xl shadow-lg shadow-teal-500/30 transition-all transform hover:-translate-y-1 active:scale-95 text-base flex items-center justify-center gap-2 group">
                    {{ __('strings.send_reset_btn') }}
                    <i data-lucide="send" class="w-4 h-4 group-hover:translate-x-1 rtl:group-hover:-translate-x-1 rtl:-scale-x-100 transition-transform"></i>
                </button>
            </form>

            <div class="text-center pt-4">
                <p class="text-sm text-slate-500">
                    {{ __('strings.remember_password') }} 
                    <a href="#" class="text-teal-600 font-bold hover:text-teal-700 hover:underline transition decoration-2 underline-offset-2">{{ __('strings.login_btn') }}</a>
                </p>
            </div>
        </div>
    </div>

    <div class="hidden md:flex w-1/2 bg-slate-50 relative items-center justify-center p-12 overflow-hidden border-l border-slate-100" dir="ltr">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-teal-100/40 via-slate-50 to-white"></div>
        <div class="absolute inset-0 opacity-30 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] bg-repeat"></div>
        
        <div class="absolute top-20 right-20 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-[90px] opacity-30 animate-float"></div>
        <div class="absolute bottom-20 left-20 w-72 h-72 bg-teal-300 rounded-full mix-blend-multiply filter blur-[90px] opacity-30 animate-float delay-300"></div>

        <div class="relative z-10 w-full max-w-lg text-center backdrop-blur-3xl">
            
            <div class="bg-white/60 backdrop-blur-xl rounded-[2.5rem] p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white/50 relative mb-10 animate-fade-in">
                
                <div class="absolute top-0 right-0 transform translate-x-4 -translate-y-4 bg-white p-3 rounded-2xl shadow-lg border border-white/50 z-20 animate-float delay-100">
                     <div class="w-10 h-10 bg-teal-50 rounded-full flex items-center justify-center text-teal-600">
                         <i data-lucide="shield-check" class="w-5 h-5"></i>
                     </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="bg-white/80 p-5 rounded-2xl border border-white shadow-sm flex flex-col items-center justify-center group hover:scale-105 transition-transform duration-500">
                        <div class="relative w-20 h-20 mb-3 flex items-center justify-center">
                            <div class="w-full h-full rounded-full border-4 border-teal-100"></div>
                            <div class="absolute w-full h-full rounded-full border-4 border-teal-500 border-t-transparent transform -rotate-45"></div>
                            <div class="absolute text-teal-600 font-bold text-sm">100%</div>
                        </div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ __('strings.secure_data') }}</span>
                    </div>

                    <div class="bg-white/80 p-5 rounded-2xl border border-white shadow-sm flex flex-col justify-between group hover:scale-105 transition-transform duration-500 delay-100">
                        <div class="flex-1 flex items-center justify-center mb-2">
                            <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-500 animate-bounce">
                                <i data-lucide="mail" class="w-6 h-6"></i>
                            </div>
                        </div>
                        <div class="text-center">
                            <h3 class="text-xs font-bold text-slate-700 uppercase mb-1">{{ __('strings.recovery') }}</h3>
                            <p class="text-[10px] text-slate-400">{{ __('strings.check_email') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-5xl font-bold text-teal-600 font-cursive mb-4 drop-shadow-sm animate-fade-in delay-200">
                payAware
            </div>
            
            <h2 class="text-3xl font-extrabold text-slate-800 mb-4 leading-tight animate-fade-in delay-200">
                {{ __('strings.secure_simple') }} <br /> <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-500 to-teal-700">{{ __('strings.account_recovery') }}</span>
            </h2>
            
            <p class="text-slate-500 text-lg max-w-sm mx-auto leading-relaxed animate-fade-in delay-300">
                {{ __('strings.recovery_hero_desc') }}
            </p>
        </div>
    </div>

<script src="{{ asset('js/authLog.js') }}"></script>
</body>
</html>