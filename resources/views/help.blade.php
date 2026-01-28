@extends('layouts.mainItems')

@section('title', __('strings.help_kb'))

@section('content')
    <main class="flex-grow">
        
        <section class="max-w-4xl mx-auto px-6 pt-16 pb-16 text-center relative">
            <div class="absolute top-0 right-0 rtl:right-auto rtl:left-0 -mr-20 rtl:-mr-0 rtl:-ml-20 -mt-20 w-64 h-64 bg-teal-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-float"></div>
            <div class="absolute bottom-0 left-0 rtl:left-auto rtl:right-0 -ml-20 rtl:-ml-0 rtl:-mr-20 -mb-20 w-64 h-64 bg-indigo-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-float" style="animation-delay: 2s"></div>

            <span class="text-teal-500 font-bold text-xs uppercase tracking-[0.2em] mb-4 block">{{ __('strings.help_kb') }}</span>
            <h1 class="text-4xl md:text-6xl font-bold text-slate-900 mb-6 tracking-tight">{{ __('strings.help_welcome') }}</h1>
            <p class="text-slate-500 text-lg mb-10 max-w-2xl mx-auto">
                {{ __('strings.help_desc') }}
            </p>
            
            <div class="relative max-w-2xl mx-auto group z-10">
                <div class="absolute inset-y-0 left-0 rtl:left-auto rtl:right-0 pl-6 rtl:pl-0 rtl:pr-6 flex items-center pointer-events-none">
                    <i data-lucide="search" class="w-6 h-6 text-slate-400 group-focus-within:text-teal-500 transition"></i>
                </div>
                <input type="text" class="block w-full pl-16 pr-6 rtl:pr-16 rtl:pl-6 py-5 bg-white border border-slate-200 rounded-2xl shadow-xl shadow-slate-200/40 focus:ring-2 focus:ring-teal-400 focus:border-transparent outline-none transition text-slate-700 placeholder-slate-400 text-lg text-left rtl:text-right" placeholder="{{ __('strings.help_search_placeholder') }}">
                <button class="absolute right-3 rtl:right-auto rtl:left-3 top-2.5 bottom-2.5 bg-teal-500 hover:bg-teal-600 text-white px-6 rounded-xl font-medium transition shadow-lg shadow-teal-200">
                    {{ __('strings.help_search_btn') }}
                </button>
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-6 pb-20">
            <div class="flex justify-between items-end mb-8">
                <h2 class="text-2xl font-bold text-slate-900">{{ __('strings.browse_topic') }}</h2>
                <a href="#" class="text-teal-500 text-sm font-semibold hover:text-teal-600 flex items-center">
                    {{ __('strings.view_all_cats') }} 
                    <i data-lucide="arrow-right" class="w-4 h-4 ml-1 rtl:mr-1 rtl:ml-0 rtl:rotate-180"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <a href="#" class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 group category-card">
                    <div class="w-14 h-14 bg-teal-50 rounded-2xl flex items-center justify-center text-teal-500 mb-6 icon-wrapper transition duration-300">
                        <i data-lucide="rocket" class="w-7 h-7"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2 group-hover:text-teal-600 transition">{{ __('strings.topic_start') }}</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">{{ __('strings.topic_start_desc') }}</p>
                </a>

                <a href="#" class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 group category-card">
                    <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-500 mb-6 icon-wrapper transition duration-300">
                        <i data-lucide="user-cog" class="w-7 h-7"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2 group-hover:text-indigo-600 transition">{{ __('strings.topic_account') }}</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">{{ __('strings.topic_account_desc') }}</p>
                </a>

                <a href="#" class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 group category-card">
                    <div class="w-14 h-14 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-500 mb-6 icon-wrapper transition duration-300">
                        <i data-lucide="wallet" class="w-7 h-7"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2 group-hover:text-orange-600 transition">{{ __('strings.topic_billing') }}</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">{{ __('strings.topic_billing_desc') }}</p>
                </a>

                <a href="#" class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 group category-card">
                    <div class="w-14 h-14 bg-pink-50 rounded-2xl flex items-center justify-center text-pink-500 mb-6 icon-wrapper transition duration-300">
                        <i data-lucide="smartphone" class="w-7 h-7"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2 group-hover:text-pink-600 transition">{{ __('strings.topic_mobile') }}</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">{{ __('strings.topic_mobile_desc') }}</p>
                </a>

                <a href="#" class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 group category-card">
                    <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-500 mb-6 icon-wrapper transition duration-300">
                        <i data-lucide="shield-check" class="w-7 h-7"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2 group-hover:text-blue-600 transition">{{ __('strings.topic_privacy') }}</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">{{ __('strings.topic_privacy_desc') }}</p>
                </a>

                <a href="#" class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 group category-card">
                    <div class="w-14 h-14 bg-green-50 rounded-2xl flex items-center justify-center text-green-500 mb-6 icon-wrapper transition duration-300">
                        <i data-lucide="code-2" class="w-7 h-7"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2 group-hover:text-green-600 transition">{{ __('strings.topic_api') }}</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">{{ __('strings.topic_api_desc') }}</p>
                </a>
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-6 pb-24">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                
                <div class="lg:col-span-2">
                    <h2 class="text-2xl font-bold text-slate-900 mb-6">{{ __('strings.pop_articles') }}</h2>
                    <div class="space-y-4">
                        <a href="#" class="flex items-center justify-between p-5 bg-white border border-slate-100 rounded-xl hover:border-teal-200 hover:shadow-md transition group">
                            <div class="flex items-center gap-4">
                                <i data-lucide="file-text" class="w-5 h-5 text-slate-400 group-hover:text-teal-500 transition"></i>
                                <span class="font-medium text-slate-700 group-hover:text-teal-700 transition">{{ __('strings.art_add_debtor') }}</span>
                            </div>
                            <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 group-hover:text-teal-500 transition rtl:rotate-180"></i>
                        </a>
                        <a href="#" class="flex items-center justify-between p-5 bg-white border border-slate-100 rounded-xl hover:border-teal-200 hover:shadow-md transition group">
                            <div class="flex items-center gap-4">
                                <i data-lucide="file-text" class="w-5 h-5 text-slate-400 group-hover:text-teal-500 transition"></i>
                                <span class="font-medium text-slate-700 group-hover:text-teal-700 transition">{{ __('strings.art_export') }}</span>
                            </div>
                            <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 group-hover:text-teal-500 transition rtl:rotate-180"></i>
                        </a>
                        <a href="#" class="flex items-center justify-between p-5 bg-white border border-slate-100 rounded-xl hover:border-teal-200 hover:shadow-md transition group">
                            <div class="flex items-center gap-4">
                                <i data-lucide="file-text" class="w-5 h-5 text-slate-400 group-hover:text-teal-500 transition"></i>
                                <span class="font-medium text-slate-700 group-hover:text-teal-700 transition">{{ __('strings.art_recurring') }}</span>
                            </div>
                            <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 group-hover:text-teal-500 transition rtl:rotate-180"></i>
                        </a>
                        <a href="#" class="flex items-center justify-between p-5 bg-white border border-slate-100 rounded-xl hover:border-teal-200 hover:shadow-md transition group">
                            <div class="flex items-center gap-4">
                                <i data-lucide="file-text" class="w-5 h-5 text-slate-400 group-hover:text-teal-500 transition"></i>
                                <span class="font-medium text-slate-700 group-hover:text-teal-700 transition">{{ __('strings.art_password') }}</span>
                            </div>
                            <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 group-hover:text-teal-500 transition rtl:rotate-180"></i>
                        </a>
                        <a href="#" class="flex items-center justify-between p-5 bg-white border border-slate-100 rounded-xl hover:border-teal-200 hover:shadow-md transition group">
                            <div class="flex items-center gap-4">
                                <i data-lucide="file-text" class="w-5 h-5 text-slate-400 group-hover:text-teal-500 transition"></i>
                                <span class="font-medium text-slate-700 group-hover:text-teal-700 transition">{{ __('strings.art_login_issue') }}</span>
                            </div>
                            <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 group-hover:text-teal-500 transition rtl:rotate-180"></i>
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-slate-50 rounded-[2rem] p-8 border border-slate-100 sticky top-24">
                        <h3 class="text-xl font-bold text-slate-900 mb-6">{{ __('strings.need_help') }}</h3>
                        
                        <div class="space-y-6">
                            <div class="flex gap-4">
                                <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center shadow-sm text-teal-500 shrink-0">
                                    <i data-lucide="message-square" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800 text-sm">{{ __('strings.live_chat') }}</h4>
                                    <p class="text-xs text-slate-500 mt-1">{{ __('strings.wait_time') }}</p>
                                    <a href="#" class="text-teal-500 text-xs font-bold mt-2 block hover:underline">{{ __('strings.start_chat') }}</a>
                                </div>
                            </div>

                            <div class="w-full h-px bg-slate-200"></div>

                            <div class="flex gap-4">
                                <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center shadow-sm text-indigo-500 shrink-0">
                                    <i data-lucide="mail" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800 text-sm">{{ __('strings.email_support') }}</h4>
                                    <p class="text-xs text-slate-500 mt-1">{{ __('strings.response_time') }}</p>
                                    <a href="#" class="text-indigo-500 text-xs font-bold mt-2 block hover:underline">{{ __('strings.send_email') }}</a>
                                </div>
                            </div>

                            <div class="w-full h-px bg-slate-200"></div>

                            <div class="flex gap-4">
                                <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center shadow-sm text-orange-500 shrink-0">
                                    <i data-lucide="users" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800 text-sm">{{ __('strings.community') }}</h4>
                                    <p class="text-xs text-slate-500 mt-1">{{ __('strings.ask_users') }}</p>
                                    <a href="#" class="text-orange-500 text-xs font-bold mt-2 block hover:underline">{{ __('strings.visit_forum') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </main>
@endsection