@extends('layouts.mainItems')

@section('title', __('strings.contact_title') ?? 'Contact Us')

@section('content')
    <main class="max-w-7xl mx-auto px-6 md:px-12 py-16 md:py-24 text-center relative overflow-hidden">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 -mt-20 w-[800px] h-[800px] bg-gradient-to-b from-teal-50 to-transparent rounded-full mix-blend-multiply filter blur-3xl opacity-50 -z-10"></div>

        <div class="animate-fade-in-up max-w-3xl mx-auto">
            <span class="text-teal-500 font-bold text-xs uppercase tracking-[0.2em] mb-4 block">{{ __('strings.contact_hero_badge') }}</span>
            <h1 class="text-5xl md:text-6xl font-extrabold text-slate-900 leading-tight mb-6">
                {{ __('strings.contact_hero_title') }}
            </h1>
            <p class="text-slate-500 text-lg leading-relaxed mb-10">
                {{ __('strings.contact_hero_desc') }}
            </p>
        </div>
    </main>

    <section class="px-6 md:px-12 max-w-7xl mx-auto -mt-8 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-50 hover:-translate-y-2 transition duration-300 group">
                <div class="w-14 h-14 rounded-2xl bg-teal-50 flex items-center justify-center text-teal-500 mb-6 group-hover:bg-teal-500 group-hover:text-white transition-colors duration-300">
                    <i data-lucide="message-square" class="w-7 h-7"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">{{ __('strings.chat_sales') }}</h3>
                <p class="text-slate-500 text-sm mb-4 leading-relaxed">{{ __('strings.chat_sales_desc') }}</p>
                <a href="#" class="text-teal-500 font-semibold text-sm flex items-center hover:text-teal-600 transition">
                    {{ __('strings.sales_email') }} 
                    <i data-lucide="arrow-right" class="w-4 h-4 ml-2 rtl:mr-2 rtl:ml-0 rtl:rotate-180"></i>
                </a>
            </div>

            <div class="bg-white p-8 rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-50 hover:-translate-y-2 transition duration-300 group">
                <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-500 mb-6 group-hover:bg-indigo-500 group-hover:text-white transition-colors duration-300">
                    <i data-lucide="life-buoy" class="w-7 h-7"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">{{ __('strings.chat_support') }}</h3>
                <p class="text-slate-500 text-sm mb-4 leading-relaxed">{{ __('strings.chat_support_desc') }}</p>
                <a href="#" class="text-indigo-500 font-semibold text-sm flex items-center hover:text-indigo-600 transition">
                    {{ __('strings.support_email') }} 
                    <i data-lucide="arrow-right" class="w-4 h-4 ml-2 rtl:mr-2 rtl:ml-0 rtl:rotate-180"></i>
                </a>
            </div>

            <div class="bg-white p-8 rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-50 hover:-translate-y-2 transition duration-300 group">
                <div class="w-14 h-14 rounded-2xl bg-orange-50 flex items-center justify-center text-orange-500 mb-6 group-hover:bg-orange-500 group-hover:text-white transition-colors duration-300">
                    <i data-lucide="map-pin" class="w-7 h-7"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">{{ __('strings.visit_us') }}</h3>
                <p class="text-slate-500 text-sm mb-4 leading-relaxed">{{ __('strings.visit_us_desc') }}</p>
                <a href="#" class="text-orange-500 font-semibold text-sm flex items-center hover:text-orange-600 transition">
                    {{ __('strings.view_maps') }} 
                    <i data-lucide="arrow-right" class="w-4 h-4 ml-2 rtl:mr-2 rtl:ml-0 rtl:rotate-180"></i>
                </a>
            </div>
        </div>
    </section>

    <section class="py-20 px-6 md:px-12 max-w-7xl mx-auto">
         <div class="bg-white rounded-[3rem] p-8 md:p-12 shadow-2xl shadow-slate-200/50 border border-slate-50 relative overflow-hidden">
             <div class="absolute top-0 left-0 w-full h-full dotted-pattern opacity-30 pointer-events-none"></div>

             <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start relative z-10">
                 
                 <div class="space-y-8">
                    <div>
                        <h2 class="text-3xl font-bold text-slate-900 mt-2">{{ __('strings.send_message_title') }}</h2>
                        <p class="text-slate-500 mt-2">
                            {{ __('strings.form_desc') }}
                        </p>
                    </div>

                    <form class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1 rtl:mr-1 rtl:ml-0">{{ __('strings.first_name') }}</label>
                                <input type="text" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-teal-400 focus:bg-white transition" placeholder="{{ __('strings.first_name') }}" />
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1 rtl:mr-1 rtl:ml-0">{{ __('strings.last_name') }}</label>
                                <input type="text" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-teal-400 focus:bg-white transition" placeholder="{{ __('strings.last_name') }}" />
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1 rtl:mr-1 rtl:ml-0">{{ __('strings.email_addr') }}</label>
                            <input type="email" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-teal-400 focus:bg-white transition" placeholder="{{ __('strings.email_placeholder') }}" />
                        </div>

                        <div class="space-y-2">
                             <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1 rtl:mr-1 rtl:ml-0">{{ __('strings.message_label') }}</label>
                             <textarea rows="4" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-teal-400 focus:bg-white transition" placeholder="{{ __('strings.message_placeholder') }}"></textarea>
                        </div>

                        <button type="button" class="w-full bg-gradient-to-r from-teal-400 to-teal-600 hover:from-teal-500 hover:to-teal-700 text-white font-bold py-4 px-10 rounded-xl shadow-lg shadow-teal-200 transition transform hover:-translate-y-1">
                            {{ __('strings.send_btn') }}
                        </button>
                    </form>
                 </div>

                 <div class="h-full min-h-[400px] w-full flex items-center justify-center bg-slate-900 rounded-[2.5rem] overflow-hidden border border-slate-800 group relative">
                     <div class="absolute inset-0 opacity-20 bg-[url('https://upload.wikimedia.org/wikipedia/commons/e/ec/World_map_blank_without_borders.svg')] bg-cover bg-center filter invert"></div>
                     
                     <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-teal-500 rounded-full mix-blend-screen filter blur-[80px] opacity-20 animate-pulse"></div>

                     <div class="relative w-full h-full">
                         <div class="absolute top-1/2 left-1/2 -ml-4 -mt-8 z-10 group-hover:scale-110 transition duration-500 text-center">
                             <div class="relative">
                                 <div class="w-4 h-4 bg-teal-400 rounded-full animate-ping absolute top-2 left-2 opacity-75"></div>
                                 <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-lg shadow-teal-900/50 relative z-10">
                                    <i data-lucide="map-pin" class="w-4 h-4 text-teal-600"></i>
                                 </div>
                             </div>
                             <div class="mt-2 bg-white/10 backdrop-blur-md px-3 py-1 rounded-full border border-white/20 text-white text-xs font-bold">{{ __('strings.hq_gaza') }}</div>
                         </div>

                         <div class="absolute top-1/4 left-1/4 rtl:left-auto rtl:right-1/4 animate-float" style="animation-delay: 1s">
                             <div class="w-2 h-2 bg-indigo-400 rounded-full"></div>
                         </div>
                         <div class="absolute bottom-1/3 right-1/3 rtl:right-auto rtl:left-1/3 animate-float" style="animation-delay: 2s">
                             <div class="w-2 h-2 bg-orange-400 rounded-full"></div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
    </section>

    <section class="py-16 px-6 md:px-12 max-w-4xl mx-auto mb-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-slate-900">{{ __('strings.faq_contact_title') }}</h2>
        </div>

        <div class="space-y-4">
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm cursor-pointer faq-item" onclick="toggleFaq(this)">
                <div class="flex justify-between items-center">
                    <h4 class="font-bold text-slate-800">{{ __('strings.faq_c_1') }}</h4>
                    <i data-lucide="chevron-down" class="w-5 h-5 text-slate-400 faq-icon"></i>
                </div>
                <div class="faq-answer">
                    <p class="text-slate-500 text-sm mt-4 leading-relaxed">
                        {{ __('strings.faq_c_1_ans') }}
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm cursor-pointer faq-item" onclick="toggleFaq(this)">
                <div class="flex justify-between items-center">
                    <h4 class="font-bold text-slate-800">{{ __('strings.faq_c_2') }}</h4>
                    <i data-lucide="chevron-down" class="w-5 h-5 text-slate-400 faq-icon"></i>
                </div>
                <div class="faq-answer">
                    <p class="text-slate-500 text-sm mt-4 leading-relaxed">
                        {{ __('strings.faq_c_2_ans') }}
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm cursor-pointer faq-item" onclick="toggleFaq(this)">
                <div class="flex justify-between items-center">
                    <h4 class="font-bold text-slate-800">{{ __('strings.faq_c_3') }}</h4>
                    <i data-lucide="chevron-down" class="w-5 h-5 text-slate-400 faq-icon"></i>
                </div>
                <div class="faq-answer">
                    <p class="text-slate-500 text-sm mt-4 leading-relaxed">
                        {{ __('strings.faq_c_3_ans') }}
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection