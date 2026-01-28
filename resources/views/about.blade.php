@extends('layouts.mainItems')

@section('title', __('strings.about_title'))

@section('content')
    @include('layouts.hero', [
        'isLink' => true, 
        'btnText' => 'strings.get_started',
        'btnLink' => route('register'),
        'extraClasses' => 'border-b border-slate-200'
    ])
    {{-- السيكشن الثاني و هو قصة المشروع  --}}
    <section class="py-20 px-6 md:px-12 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-start">
                {{-- ستايل القصة والتعامل معها  --}}
            <div class="space-y-8 sticky top-24">
                <div class="inline-block px-3 py-1 bg-teal-50 text-teal-600 rounded-full text-xs font-bold tracking-widest uppercase">{{ __('strings.our_story_badge') }}</div>
                <h3 class="text-4xl font-bold text-slate-900 leading-tight">{{ __('strings.story_title') }}</h3>
                <p class="text-slate-500 leading-relaxed text-lg">
                    {{ __('strings.story_desc') }}
                </p>
                <div class="flex items-center space-x-4 rtl:space-x-reverse p-4 bg-white rounded-xl shadow-sm border border-slate-100">
                   <div class="w-12 h-12 rounded-full bg-gradient-to-br from-orange-400 to-pink-500 flex items-center justify-center text-white shadow-lg shrink-0">
                       <i data-lucide="heart" class="w-6 h-6 fill-current"></i>
                   </div>
                   <div>
                       <p class="text-sm font-bold text-slate-800">{{ __('strings.built_passion') }}</p>
                       <p class="text-xs text-slate-400">{{ __('strings.serving_since') }}</p>
                   </div>
                </div>
            </div>
             {{-- نقاط القصة  --}}

            <div class="space-y-8 relative">
                <div class="absolute left-[19px] rtl:left-auto rtl:right-[19px] top-4 bottom-4 w-0.5 bg-slate-100"></div>

                <div class="relative flex items-start space-x-6 rtl:space-x-reverse group">
                    <div class="w-10 h-10 rounded-full bg-white border-4 border-teal-50 text-teal-600 flex items-center justify-center font-bold z-10 shadow-sm group-hover:bg-teal-500 group-hover:text-white transition duration-300 shrink-0">01</div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex-1 group-hover:shadow-md transition duration-300">
                        <h4 class="font-bold text-slate-800 text-lg mb-2">{{ __('strings.timeline_1_title') }}</h4>
                        <p class="text-slate-500 leading-relaxed text-sm">{{ __('strings.timeline_1_desc') }}</p>
                    </div>
                </div>
                <div class="relative flex items-start space-x-6 rtl:space-x-reverse group">
                     <div class="w-10 h-10 rounded-full bg-white border-4 border-teal-50 text-teal-600 flex items-center justify-center font-bold z-10 shadow-sm group-hover:bg-teal-500 group-hover:text-white transition duration-300 shrink-0">02</div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex-1 group-hover:shadow-md transition duration-300">
                        <h4 class="font-bold text-slate-800 text-lg mb-2">{{ __('strings.timeline_2_title') }}</h4>
                        <p class="text-slate-500 leading-relaxed text-sm">{{ __('strings.timeline_2_desc') }}</p>
                    </div>
                </div>
                <div class="relative flex items-start space-x-6 rtl:space-x-reverse group">
                     <div class="w-10 h-10 rounded-full bg-white border-4 border-teal-50 text-teal-600 flex items-center justify-center font-bold z-10 shadow-sm group-hover:bg-teal-500 group-hover:text-white transition duration-300 shrink-0">03</div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex-1 group-hover:shadow-md transition duration-300">
                        <h4 class="font-bold text-slate-800 text-lg mb-2">{{ __('strings.timeline_3_title') }}</h4>
                        <p class="text-slate-500 leading-relaxed text-sm">{{ __('strings.timeline_3_desc') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- السيكشن الثالث و هو من نحن لتعريف المستخدمين بالفريق --}}

    <section class="py-20 px-6 md:px-12 max-w-7xl mx-auto">
        <div class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-xl shadow-slate-200/50 border border-slate-50 relative overflow-hidden">
            <div class="absolute top-0 right-0 rtl:right-auto rtl:left-0 w-full h-full dotted-pattern opacity-30"></div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center relative z-10">
                <div class="space-y-6">
                    <h3 class="text-3xl md:text-4xl font-bold text-slate-900 uppercase tracking-tight">{{ __('strings.who_we_are') }}</h3>
                    <div class="w-20 h-1.5 bg-teal-500 rounded-full"></div>
                    <p class="text-slate-500 leading-relaxed text-lg">
                        {{ __('strings.who_desc') }}
                    </p>
                    <ul class="space-y-3 pt-4">
                        <li class="flex items-center text-slate-600 font-medium"><i data-lucide="check-circle-2" class="w-5 h-5 text-teal-500 mr-3 rtl:ml-3 rtl:mr-0"></i> {{ __('strings.secure_trans') }}</li>
                        <li class="flex items-center text-slate-600 font-medium"><i data-lucide="check-circle-2" class="w-5 h-5 text-teal-500 mr-3 rtl:ml-3 rtl:mr-0"></i> {{ __('strings.real_time') }}</li>
                        <li class="flex items-center text-slate-600 font-medium"><i data-lucide="check-circle-2" class="w-5 h-5 text-teal-500 mr-3 rtl:ml-3 rtl:mr-0"></i> {{ __('strings.support_247') }}</li>
                    </ul>
                </div>
                
                <div class="relative rounded-3xl overflow-hidden shadow-2xl group cursor-pointer border-4 border-white">
                    <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80" alt="About Us Video" class="w-full h-80 object-cover transition duration-700 group-hover:scale-110" />
                    <div class="absolute inset-0 bg-indigo-900/20 group-hover:bg-indigo-900/10 transition duration-300"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-20 h-20 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-lg transition transform group-hover:scale-110 play-btn-pulse">
                            <i data-lucide="play" class="w-8 h-8 text-teal-500 fill-current ml-1 rtl:mr-1 rtl:ml-0"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- سيكشن الهدف الاساسي من المشروع   --}}

    <section class="py-20 px-6 md:px-12 max-w-7xl mx-auto bg-slate-50 rounded-[3rem] my-10">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
             <div class="space-y-10">
                <div>
                    <h3 class="text-4xl font-bold text-slate-900 mb-4">{{ __('strings.primary_goal') }}</h3>
                    <p class="text-slate-500 leading-relaxed">
                        {{ __('strings.goal_desc') }}
                    </p>
                </div>
                
                <div class="flex flex-wrap gap-8">
                    <div class="text-center group">
                        <div class="relative w-20 h-20 flex items-center justify-center rounded-full bg-white shadow-sm border-4 border-teal-100 group-hover:border-teal-400 transition duration-300 mb-3 mx-auto">
                            <span class="font-bold text-xl text-slate-800">100%</span>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500 group-hover:text-teal-600 transition">{{ __('strings.client_sat') }}</span>
                    </div>
                    <div class="text-center group">
                        <div class="relative w-20 h-20 flex items-center justify-center rounded-full bg-white shadow-sm border-4 border-indigo-100 group-hover:border-indigo-400 transition duration-300 mb-3 mx-auto">
                            <span class="font-bold text-xl text-slate-800">50k+</span>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500 group-hover:text-indigo-600 transition">{{ __('strings.active_users') }}</span>
                    </div>
                    <div class="text-center group">
                        <div class="relative w-20 h-20 flex items-center justify-center rounded-full bg-white shadow-sm border-4 border-orange-100 group-hover:border-orange-400 transition duration-300 mb-3 mx-auto">
                            <span class="font-bold text-xl text-slate-800">24/7</span>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500 group-hover:text-orange-600 transition">{{ __('strings.support_avail') }}</span>
                    </div>
                </div>
            </div>

            <div class="flex justify-center md:justify-end relative">
                <div class="absolute inset-0 bg-teal-200 rounded-[2rem] rotate-3 transform translate-x-2 translate-y-2 opacity-50"></div>
                <div class="bg-white rounded-[2rem] overflow-hidden max-w-sm shadow-xl relative z-10">
                    <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-1.2.1&auto=format&fit=crop&w=700&q=80" alt="Team Goal" class="object-cover w-full h-96" />
                    <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/70 to-transparent p-6">
                        <p class="text-white font-bold text-lg">{{ __('strings.driven_results') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- سيكشن الرؤية المستقبلية للمشروع  --}}
    <section class="py-20 px-6 md:px-12 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
            <div class="flex justify-center md:justify-start order-2 md:order-1 relative">
                <div class="absolute -left-10 rtl:left-auto rtl:-right-10 -top-10 w-40 h-40 bg-orange-50 rounded-full mix-blend-multiply filter blur-2xl opacity-70"></div>
                <div class="absolute -right-10 rtl:right-auto rtl:-left-10 -bottom-10 w-40 h-40 bg-teal-50 rounded-full mix-blend-multiply filter blur-2xl opacity-70"></div>
                
                <div class="bg-white p-2 rounded-[2rem] shadow-2xl relative z-10 transform -rotate-2 hover:rotate-0 transition duration-500">
                     <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?ixlib=rb-1.2.1&auto=format&fit=crop&w=700&q=80" alt="Vision" class="object-cover w-full h-80 rounded-[1.5rem]" />
                </div>
            </div>

            <div class="space-y-6 order-1 md:order-2">
                <div class="inline-block px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-xs font-bold tracking-widest uppercase">{{ __('strings.the_future') }}</div>
                <h3 class="text-4xl font-bold text-slate-900">{{ __('strings.vision_title') }}</h3>
                <p class="text-slate-500 leading-relaxed text-lg">
                    {{ __('strings.vision_desc') }}
                </p>
                <div class="border-l-4 rtl:border-l-0 rtl:border-r-4 border-indigo-500 pl-6 rtl:pl-0 rtl:pr-6 py-2">
                    <p class="text-slate-800 font-medium italic">{{ __('strings.quote_innovation') }}</p>
                </div>
            </div>
        </div>
    </section>
    {{-- سيكشن اراء العملاء لعرض اراء العملاء ولن يتم التعامل معه الان في الداتا بيز  --}}
    <section class="py-24 px-6 md:px-12 max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <span class="text-teal-500 font-bold text-xs uppercase tracking-[0.2em]">{{ __('strings.testimonials') }}</span>
            <h2 class="text-4xl font-bold text-slate-900 mt-3">{{ __('strings.trusted_by') }}</h2>
        </div>

        <div class="bg-white rounded-[2rem] shadow-xl border border-slate-100 p-8 md:p-12 relative overflow-hidden group">
            <i data-lucide="quote" class="absolute top-8 right-8 rtl:right-auto rtl:left-8 text-slate-50 w-32 h-32 fill-current transform rotate-180"></i>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center relative z-10">
                <div class="md:col-span-4 relative">
                    <div class="rounded-2xl overflow-hidden h-72 w-full relative shadow-lg">
                         <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" alt="Client" class="object-cover w-full h-full transform group-hover:scale-105 transition duration-700" />
                         <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                         <div class="absolute bottom-4 left-4 rtl:left-auto rtl:right-4 text-white">
                             <p class="font-bold">Sarah Ammar</p>
                             <p class="text-xs opacity-80">{{ __('strings.sarah_job') }}</p>
                         </div>
                    </div>
                </div>
                    {{-- للتقييم   --}}

                <div class="md:col-span-8 space-y-6 md:pl-8 rtl:md:pl-0 rtl:md:pr-8">
                    <div class="flex space-x-1 text-yellow-400">
                        <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                    </div>
                    <h4 class="text-2xl md:text-3xl font-bold text-slate-800 leading-snug font-serif italic">
                        {{ __('strings.testi_quote') }}
                    </h4>
                    
                    <div class="flex items-center space-x-4 rtl:space-x-reverse mt-4">
                        <button class="w-10 h-10 rounded-full border border-slate-200 flex items-center justify-center hover:bg-teal-500 hover:text-white hover:border-teal-500 transition">
                            <i data-lucide="arrow-left" class="w-4 h-4 rtl:rotate-180"></i>
                        </button>
                        <button class="w-10 h-10 rounded-full border border-slate-200 flex items-center justify-center hover:bg-teal-500 hover:text-white hover:border-teal-500 transition">
                            <i data-lucide="arrow-right" class="w-4 h-4 rtl:rotate-180"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection