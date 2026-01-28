<footer class="bg-[#0f172a] text-white py-16 relative overflow-hidden mt-20" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-teal-400 via-indigo-500 to-orange-400"></div>
    
    <div class="max-w-7xl mx-auto px-6 md:px-12 grid grid-cols-1 md:grid-cols-4 gap-12 relative z-10">
        <!--شعار موقعنا --> 

        <div class="col-span-1 md:col-span-1 space-y-4">
             <div class="text-4xl font-bold text-teal-400 font-cursive">
                payAware
            </div>
            <p class="text-slate-400 text-sm leading-relaxed">
                {{ __('strings.slogan') }}
            </p>
        </div>
<!--المنيو داخل الفوتر --> 
        <div>
             <h4 class="text-sm font-bold uppercase tracking-wider mb-6 text-slate-300">{{ __('strings.explore') }}</h4>
             <ul class="space-y-3 text-sm text-slate-400">
                 <li>
                     <a href="{{ route('home') }}" class="hover:text-teal-400 transition flex items-center group">
                         <span class="w-0 group-hover:w-2 transition-all h-0.5 bg-teal-400 mr-0 group-hover:mr-2 rtl:group-hover:mr-0 rtl:group-hover:ml-2"></span> 
                         {{ __('strings.home') }}
                     </a>
                 </li>
                 <li>
                     <a href="{{ route('about') }}" class="hover:text-teal-400 transition flex items-center group">
                         <span class="w-0 group-hover:w-2 transition-all h-0.5 bg-teal-400 mr-0 group-hover:mr-2 rtl:group-hover:mr-0 rtl:group-hover:ml-2"></span> 
                         {{ __('strings.about') }}
                     </a>
                 </li>
                 <li>
                     <a href="#" class="hover:text-teal-400 transition flex items-center group">
                         <span class="w-0 group-hover:w-2 transition-all h-0.5 bg-teal-400 mr-0 group-hover:mr-2 rtl:group-hover:mr-0 rtl:group-hover:ml-2"></span> 
                         {{ __('strings.features') }}
                     </a>
                 </li>
             </ul>
        </div>
<!-- العامود الثاني للقائمة  وهو للدعم وتم اضافة بند الاشروط و السياسة لو اردنا اضافتهم لاحقا -->
         <div>
             <h4 class="text-sm font-bold uppercase tracking-wider mb-6 text-slate-300">{{ __('strings.support') }}</h4>
             <ul class="space-y-3 text-sm text-slate-400">
                 <li><a href="{{ route('help') }}" class="hover:text-teal-400 transition flex items-center">{{ __('strings.help_center') }}</a></li>
                 <li><a href="#" class="hover:text-teal-400 transition flex items-center">{{ __('strings.terms') }}</a></li>
                 <li><a href="#" class="hover:text-teal-400 transition flex items-center">{{ __('strings.privacy') }}</a></li>
             </ul>
        </div>
<!--عامود التفاصيل -->
        <div>
            <h4 class="text-sm font-bold uppercase tracking-wider mb-6 text-slate-300">{{ __('strings.get_in_touch') }}</h4>
            <ul class="space-y-4 text-sm text-slate-400">
                <li class="flex items-center space-x-3 rtl:space-x-reverse">
                    <div class="w-8 h-8 rounded bg-slate-800 flex items-center justify-center text-teal-400 shrink-0">
                         <i data-lucide="map-pin" class="w-4 h-4"></i>
                    </div>
                    <span>{{ __('strings.address') }}</span>
                </li>
                <li class="flex items-center space-x-3 rtl:space-x-reverse">
                    <div class="w-8 h-8 rounded bg-slate-800 flex items-center justify-center text-teal-400 shrink-0">
                         <i data-lucide="mail" class="w-4 h-4"></i>
                    </div>
                    <span>contact@payaware.com</span>
                </li>
            </ul>
<!--تفاصيل السوشيال ميديا -->
            <div class="mt-8 flex space-x-3 rtl:space-x-reverse">
                 <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-teal-500 hover:text-white transition">
                    <i data-lucide="linkedin" class="w-4 h-4"></i>
                 </a>
                 <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-teal-500 hover:text-white transition">
                    <i data-lucide="twitter" class="w-4 h-4"></i>
                 </a>
                 <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-teal-500 hover:text-white transition">
                    <i data-lucide="facebook" class="w-4 h-4"></i>
                 </a>
             </div>
        </div>
    </div>
<!--لحقوق الموقع يمكن ان نزيلها اذا لا نريدها -->
    <div class="border-t border-slate-800 mt-16 pt-8 text-center">
        <p class="text-xs text-slate-500">&copy; 2025 payAware. {{ __('strings.rights') }}</p>
    </div>
</footer>