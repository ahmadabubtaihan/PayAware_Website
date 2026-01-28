@extends('layouts.mainItems')

@section('title', __('strings.faq'))

@section('content')
    <main class="flex-grow">
        
        <section class="max-w-4xl mx-auto px-6 pt-16 pb-12 text-center relative">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 -mt-20 w-[600px] h-[600px] bg-gradient-to-b from-teal-50/50 to-transparent rounded-full mix-blend-multiply filter blur-3xl opacity-50 -z-10"></div>
            
            <span class="text-teal-500 font-bold text-xs uppercase tracking-[0.2em] mb-4 block">{{ __('strings.help_center') }}</span>
            <h1 class="text-4xl md:text-5xl font-bold text-slate-900 mb-6 tracking-tight">{{ __('strings.how_can_we_help') }}</h1>
            
            <div class="relative max-w-xl mx-auto mt-8 group">
                <div class="absolute inset-y-0 left-0 pl-4 rtl:left-auto rtl:right-0 rtl:pl-0 rtl:pr-4 flex items-center pointer-events-none">
                    <i data-lucide="search" class="w-5 h-5 text-slate-400 group-focus-within:text-teal-500 transition"></i>
                </div>
                <input type="text" class="block w-full pl-12 pr-4 rtl:pr-12 rtl:pl-4 py-4 bg-white border border-slate-200 rounded-full shadow-lg shadow-slate-200/50 focus:ring-2 focus:ring-teal-400 focus:border-transparent outline-none transition text-slate-700 placeholder-slate-400 text-left rtl:text-right" placeholder="{{ __('strings.search_placeholder') }}">
            </div>
        </section>

        <section class="max-w-6xl mx-auto px-6 pb-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-[1.5rem] border border-slate-100 shadow-sm text-center hover:shadow-md hover:border-teal-100 transition cursor-pointer group">
                    <div class="w-12 h-12 mx-auto bg-teal-50 rounded-2xl flex items-center justify-center text-teal-500 mb-4 group-hover:scale-110 transition">
                        <i data-lucide="zap" class="w-6 h-6"></i>
                    </div>
                    <h3 class="font-bold text-slate-800 mb-1">{{ __('strings.cat_getting_started') }}</h3>
                    <p class="text-xs text-slate-400">{{ __('strings.cat_setup') }}</p>
                </div>
                <div class="bg-white p-6 rounded-[1.5rem] border border-slate-100 shadow-sm text-center hover:shadow-md hover:border-teal-100 transition cursor-pointer group">
                    <div class="w-12 h-12 mx-auto bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-500 mb-4 group-hover:scale-110 transition">
                        <i data-lucide="user" class="w-6 h-6"></i>
                    </div>
                    <h3 class="font-bold text-slate-800 mb-1">{{ __('strings.cat_account') }}</h3>
                    <p class="text-xs text-slate-400">{{ __('strings.cat_profile') }}</p>
                </div>
                <div class="bg-white p-6 rounded-[1.5rem] border border-slate-100 shadow-sm text-center hover:shadow-md hover:border-teal-100 transition cursor-pointer group">
                    <div class="w-12 h-12 mx-auto bg-orange-50 rounded-2xl flex items-center justify-center text-orange-500 mb-4 group-hover:scale-110 transition">
                        <i data-lucide="credit-card" class="w-6 h-6"></i>
                    </div>
                    <h3 class="font-bold text-slate-800 mb-1">{{ __('strings.cat_billing') }}</h3>
                    <p class="text-xs text-slate-400">{{ __('strings.cat_payments') }}</p>
                </div>
                <div class="bg-white p-6 rounded-[1.5rem] border border-slate-100 shadow-sm text-center hover:shadow-md hover:border-teal-100 transition cursor-pointer group">
                    <div class="w-12 h-12 mx-auto bg-pink-50 rounded-2xl flex items-center justify-center text-pink-500 mb-4 group-hover:scale-110 transition">
                        <i data-lucide="shield-check" class="w-6 h-6"></i>
                    </div>
                    <h3 class="font-bold text-slate-800 mb-1">{{ __('strings.cat_security') }}</h3>
                    <p class="text-xs text-slate-400">{{ __('strings.cat_privacy') }}</p>
                </div>
            </div>
        </section>

        <section class="max-w-3xl mx-auto px-6 pb-24">
            <div class="space-y-6">
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-slate-900">{{ __('strings.top_questions') }}</h2>
                </div>

                <div class="bg-white rounded-[1.5rem] border border-slate-100 p-6 shadow-sm cursor-pointer faq-item group" onclick="toggleFaq(this)">
                    <div class="flex justify-between items-center">
                        <h4 class="font-bold text-slate-800 text-lg group-hover:text-teal-600 transition">{{ __('strings.q1_title') }}</h4>
                        <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center group-hover:bg-teal-50 transition shrink-0">
                            <i data-lucide="chevron-down" class="w-5 h-5 text-slate-400 faq-icon group-hover:text-teal-500"></i>
                        </div>
                    </div>
                    <div class="faq-answer">
                        <div class="pt-4 text-slate-500 text-sm leading-relaxed border-t border-slate-50 mt-4">
                            <p>{{ __('strings.q1_ans_1') }}</p>
                            <p class="mt-2">{{ __('strings.q1_ans_2') }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-[1.5rem] border border-slate-100 p-6 shadow-sm cursor-pointer faq-item group" onclick="toggleFaq(this)">
                    <div class="flex justify-between items-center">
                        <h4 class="font-bold text-slate-800 text-lg group-hover:text-teal-600 transition">{{ __('strings.q2_title') }}</h4>
                        <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center group-hover:bg-teal-50 transition shrink-0">
                            <i data-lucide="chevron-down" class="w-5 h-5 text-slate-400 faq-icon group-hover:text-teal-500"></i>
                        </div>
                    </div>
                    <div class="faq-answer">
                        <div class="pt-4 text-slate-500 text-sm leading-relaxed border-t border-slate-50 mt-4">
                            <p>{{ __('strings.q2_ans') }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-[1.5rem] border border-slate-100 p-6 shadow-sm cursor-pointer faq-item group" onclick="toggleFaq(this)">
                    <div class="flex justify-between items-center">
                        <h4 class="font-bold text-slate-800 text-lg group-hover:text-teal-600 transition">{{ __('strings.q3_title') }}</h4>
                        <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center group-hover:bg-teal-50 transition shrink-0">
                            <i data-lucide="chevron-down" class="w-5 h-5 text-slate-400 faq-icon group-hover:text-teal-500"></i>
                        </div>
                    </div>
                    <div class="faq-answer">
                        <div class="pt-4 text-slate-500 text-sm leading-relaxed border-t border-slate-50 mt-4">
                            <p>{{ __('strings.q3_ans') }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-[1.5rem] border border-slate-100 p-6 shadow-sm cursor-pointer faq-item group" onclick="toggleFaq(this)">
                    <div class="flex justify-between items-center">
                        <h4 class="font-bold text-slate-800 text-lg group-hover:text-teal-600 transition">{{ __('strings.q4_title') }}</h4>
                        <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center group-hover:bg-teal-50 transition shrink-0">
                            <i data-lucide="chevron-down" class="w-5 h-5 text-slate-400 faq-icon group-hover:text-teal-500"></i>
                        </div>
                    </div>
                    <div class="faq-answer">
                        <div class="pt-4 text-slate-500 text-sm leading-relaxed border-t border-slate-50 mt-4">
                            <p>{{ __('strings.q4_ans') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="max-w-4xl mx-auto px-6 pb-24 text-center">
            <div class="bg-slate-50 rounded-[2rem] p-8 md:p-12 border border-slate-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 rtl:right-auto rtl:left-0 w-32 h-32 bg-teal-100 rounded-full mix-blend-multiply filter blur-2xl opacity-50"></div>
                
                <h3 class="text-2xl font-bold text-slate-900 mb-3 relative z-10">{{ __('strings.still_questions') }}</h3>
                <p class="text-slate-500 text-sm mb-8 max-w-lg mx-auto relative z-10">
                    {{ __('strings.cant_find_ans') }}
                </p>
                <a href="{{ route('contact') }}" role="button" class="bg-teal-500 hover:bg-teal-600 text-white font-bold py-3 px-8 rounded-full shadow-lg shadow-teal-200 transition transform hover:-translate-y-1 relative z-10">
                    {{ __('strings.get_in_touch_btn') }}
                </a>
            </div>
        </section>

    </main>
@endsection