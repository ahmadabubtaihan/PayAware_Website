@extends('layouts.mainItems')

@section('title', __('strings.home'))

@section('content')
    @include('layouts.hero', [
        'isLink' => true,
        'btnText' => 'strings.signup_btn',
        'btnLink' => route('register')
    ])
    {{-- أول سيكشن الخدمات --}}
    <section class="py-24 px-6 md:px-12 max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <span class="text-teal-500 font-bold text-xs uppercase tracking-[0.2em]">{{ __('strings.our_services') }}</span>
            <h2 class="text-4xl font-bold text-slate-900 mt-3">{{ __('strings.valuable_features') }}</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-10 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-50 group hover:-translate-y-2 transition duration-300 relative overflow-hidden">
                <div class="absolute top-0 right-0 rtl:right-auto rtl:left-0 w-32 h-32 bg-orange-50 rounded-bl-[50%] rtl:rounded-bl-none rtl:rounded-br-[50%] -mr-8 rtl:-mr-0 rtl:-ml-8 -mt-8 transition group-hover:scale-110"></div>
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-orange-400 to-red-500 flex items-center justify-center text-white shadow-lg shadow-orange-200 mb-8 relative z-10">
                     <i data-lucide="clipboard-list" class="w-8 h-8"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-4 group-hover:text-orange-500 transition">{{ __('strings.debt_mgmt') }}</h3>
                <p class="text-slate-500 leading-relaxed">
                    {{ __('strings.debt_desc') }}
                </p>
            </div>

            <div class="bg-white p-10 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-50 group hover:-translate-y-2 transition duration-300 relative overflow-hidden">
                <div class="absolute top-0 right-0 rtl:right-auto rtl:left-0 w-32 h-32 bg-indigo-50 rounded-bl-[50%] rtl:rounded-bl-none rtl:rounded-br-[50%] -mr-8 rtl:-mr-0 rtl:-ml-8 -mt-8 transition group-hover:scale-110"></div>
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center text-white shadow-lg shadow-indigo-200 mb-8 relative z-10">
                     <i data-lucide="search" class="w-8 h-8"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-4 group-hover:text-indigo-600 transition">{{ __('strings.search_history') }}</h3>
                <p class="text-slate-500 leading-relaxed">
                    {{ __('strings.search_desc') }}
                </p>
            </div>

            <div class="bg-white p-10 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-50 group hover:-translate-y-2 transition duration-300 relative overflow-hidden">
                <div class="absolute top-0 right-0 rtl:right-auto rtl:left-0 w-32 h-32 bg-teal-50 rounded-bl-[50%] rtl:rounded-bl-none rtl:rounded-br-[50%] -mr-8 rtl:-mr-0 rtl:-ml-8 -mt-8 transition group-hover:scale-110"></div>
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-teal-400 to-green-500 flex items-center justify-center text-white shadow-lg shadow-teal-200 mb-8 relative z-10">
                     <i data-lucide="bell-ring" class="w-8 h-8"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-4 group-hover:text-teal-500 transition">{{ __('strings.smart_alerts') }}</h3>
                <p class="text-slate-500 leading-relaxed">
                    {{ __('strings.alerts_desc') }}
                </p>
            </div>
        </div>
    </section>


    {{-- ثاني سيكشن فريق العمل  --}}
    <section class="py-24 px-6 md:px-12 max-w-7xl mx-auto bg-slate-50 rounded-[3rem] my-12">
        <div class="text-center mb-16">
            <span class="text-indigo-600 font-bold text-xs uppercase tracking-[0.2em]">{{ __('strings.the_team') }}</span>
            <h2 class="text-4xl font-bold text-slate-900 mt-3">{{ __('strings.dedicated_devs') }}</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="bg-white p-4 rounded-[2rem] shadow-lg border border-slate-100 group hover:shadow-2xl transition duration-500">
                <div class="rounded-[1.5rem] overflow-hidden mb-6 h-64 bg-blue-50 relative flex items-center justify-center group-hover:bg-blue-100 transition">
                    <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d" alt="Hammam" class="w-48 h-48 object-cover transition duration-500 group-hover:scale-110 drop-shadow-md" />
                </div>
                <div class="text-center pb-4">
                    <h3 class="text-xl font-bold text-slate-900">Hammam AbuMadin</h3>
                    <p class="text-teal-500 font-medium text-sm mb-4">{{ __('strings.lead_dev') }}</p>
                    <div class="flex justify-center space-x-3 rtl:space-x-reverse text-slate-300">
                        <i data-lucide="linkedin" class="w-5 h-5 hover:text-indigo-600 cursor-pointer transition transform hover:scale-110"></i>
                        <i data-lucide="twitter" class="w-5 h-5 hover:text-blue-400 cursor-pointer transition transform hover:scale-110"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-4 rounded-[2rem] shadow-lg border border-slate-100 group hover:shadow-2xl transition duration-500">
                <div class="rounded-[1.5rem] overflow-hidden mb-6 h-64 bg-purple-50 relative flex items-center justify-center group-hover:bg-purple-100 transition">
                    <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d" alt="Mohammed Al-Hour" class="w-48 h-48 object-cover transition duration-500 group-hover:scale-110 drop-shadow-md" />
                </div>
                <div class="text-center pb-4">
                    <h3 class="text-xl font-bold text-slate-900">Mohammed Al-Hour</h3>
                    <p class="text-teal-500 font-medium text-sm mb-4">{{ __('strings.frontend_eng') }}</p>
                    <div class="flex justify-center space-x-3 rtl:space-x-reverse text-slate-300">
                        <i data-lucide="linkedin" class="w-5 h-5 hover:text-indigo-600 cursor-pointer transition transform hover:scale-110"></i>
                        <i data-lucide="twitter" class="w-5 h-5 hover:text-blue-400 cursor-pointer transition transform hover:scale-110"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-[2rem] shadow-lg border border-slate-100 group hover:shadow-2xl transition duration-500">
                <div class="rounded-[1.5rem] overflow-hidden mb-6 h-64 bg-orange-50 relative flex items-center justify-center group-hover:bg-orange-100 transition">
                    <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d" alt="Baraa" class="w-48 h-48 object-cover transition duration-500 group-hover:scale-110 drop-shadow-md" />
                </div>
                <div class="text-center pb-4">
                    <h3 class="text-xl font-bold text-slate-900">Baraa Al-Afifi</h3>
                    <p class="text-teal-500 font-medium text-sm mb-4">{{ __('strings.ui_designer') }}</p>
                    <div class="flex justify-center space-x-3 rtl:space-x-reverse text-slate-300">
                        <i data-lucide="linkedin" class="w-5 h-5 hover:text-indigo-600 cursor-pointer transition transform hover:scale-110"></i>
                        <i data-lucide="twitter" class="w-5 h-5 hover:text-blue-400 cursor-pointer transition transform hover:scale-110"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-[2rem] shadow-lg border border-slate-100 group hover:shadow-2xl transition duration-500">
                <div class="rounded-[1.5rem] overflow-hidden mb-6 h-64 bg-teal-50 relative flex items-center justify-center group-hover:bg-teal-100 transition">
                    <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d" alt="Mohammed Eslim" class="w-48 h-48 object-cover transition duration-500 group-hover:scale-110 drop-shadow-md" />
                </div>
                <div class="text-center pb-4">
                    <h3 class="text-xl font-bold text-slate-900">Mohammed Aslim</h3>
                    <p class="text-teal-500 font-medium text-sm mb-4">{{ __('strings.marketing') }}</p>
                    <div class="flex justify-center space-x-3 rtl:space-x-reverse text-slate-300">
                        <i data-lucide="linkedin" class="w-5 h-5 hover:text-indigo-600 cursor-pointer transition transform hover:scale-110"></i>
                        <i data-lucide="twitter" class="w-5 h-5 hover:text-blue-400 cursor-pointer transition transform hover:scale-110"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>
     {{--مربع التواصل --}}
    <section class="py-20 px-6 md:px-12 max-w-7xl mx-auto mb-16">
         <div class="bg-white rounded-[3rem] p-8 md:p-12 shadow-2xl shadow-slate-200/50 border border-slate-50 relative overflow-hidden">
             <div class="absolute top-0 left-0 w-full h-full dotted-pattern opacity-30 pointer-events-none"></div>

             <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center relative z-10">
                 <div class="space-y-8">
                    <div>
                        <span class="text-teal-500 font-bold text-xs uppercase tracking-[0.2em]">{{ __('strings.get_in_touch') }}</span>
                        <h2 class="text-4xl font-bold text-slate-900 mt-2">{{ __('strings.report_problem') }}</h2>
                        <p class="text-slate-500 text-lg mt-3 leading-relaxed">
                            {{ __('strings.contact_desc') }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1 rtl:mr-1 rtl:ml-0">{{ __('strings.email_label') }}</label>
                            <input type="email" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-teal-400 focus:bg-white transition" placeholder="{{ __('strings.email_placeholder') }}@example.com" />
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1 rtl:mr-1 rtl:ml-0">{{ __('strings.name_label') }}</label>
                            <input type="text" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-teal-400 focus:bg-white transition" placeholder="{{ __('strings.fullname') }}" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                             <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1 rtl:mr-1 rtl:ml-0">{{ __('strings.phone_label') }}</label>
                             <input type="tel" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-teal-400 focus:bg-white transition text-left rtl:text-right" placeholder="+1 (555) 000-0000" />
                        </div>
                        <div class="space-y-2">
                             <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1 rtl:mr-1 rtl:ml-0">{{ __('strings.subject_label') }}</label>
                             <input type="text" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-teal-400 focus:bg-white transition" placeholder="General Inquiry" />
                        </div>
                    </div>

                    <button class="bg-gradient-to-r from-teal-400 to-teal-600 hover:from-teal-500 hover:to-teal-700 text-white font-bold py-4 px-10 rounded-xl shadow-lg shadow-teal-200 transition transform hover:-translate-y-1 w-full md:w-auto">
                        {{ __('strings.send_msg') }}
                    </button>
                 </div>

                 <div class="relative h-96 w-full flex items-center justify-center bg-slate-900 rounded-[2.5rem] overflow-hidden border border-slate-800 group relative">
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
                     </div>
                 </div>
             </div>
         </div>
    </section>
@endsection