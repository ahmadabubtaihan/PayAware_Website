@extends('layouts.debtor')

@section('title', __('strings.dashboard'))

@push('head-scripts')
{{-- مكتبة الأيقونات --}}
<script src="https://unpkg.com/lucide@latest"></script>
@endpush

@section('content')
<main class="pt-28 pb-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        
    <div class="bg-gradient-to-r from-teal-600 to-emerald-600 rounded-[2.5rem] p-8 md:p-10 shadow-xl shadow-teal-200/50 text-white mb-8 relative overflow-hidden flex flex-col md:flex-row items-center justify-between">
        <div class="absolute top-0 right-0 rtl:left-0 rtl:right-auto w-64 h-64 bg-white/10 rounded-full -mr-16 rtl:-ml-16 rtl:-mr-0 -mt-16 blur-3xl pointer-events-none"></div>
        
        <div class="relative z-10 space-y-4 text-center md:text-right">
            <h1 class="text-3xl font-extrabold mb-1">
                {{ __('strings.welcome_back', ['name' => explode(' ', $user->name)[0]]) }} 👋
            </h1>
            <p class="text-teal-100 text-sm max-w-lg leading-relaxed">
                {{ __('strings.credit_score_msg') ?? 'حافظ على سجل سداد نظيف لرفع نقاطك الائتمانية والحصول على تسهيلات أكبر.' }}
            </p>
{{-- زر تحميل الشهادة --}}
<div class="flex gap-3 pt-2 justify-center md:justify-start">
    <a href="{{ route('debtor.certificate.download') }}" class="bg-white text-teal-700 font-bold py-3 px-6 rounded-2xl shadow-lg transition hover:bg-teal-50 text-sm flex items-center gap-2">
        <i data-lucide="file-check" class="w-4 h-4"></i> {{ __('strings.download_cert') ?? 'تحميل شهادة براءة ذمة' }}
    </a>
</div>        </div>
        
        {{-- رسم بياني لنقاط الائتمان --}}
        <div class="relative mt-8 md:mt-0 bg-white/10 p-5 rounded-3xl backdrop-blur-md border border-white/20 shadow-lg">
            <div class="flex items-center gap-5">
                <div class="relative w-20 h-20">
                    <svg viewBox="0 0 36 36" class="w-full h-full transform -rotate-90">
                        <path class="text-teal-900/40" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3" />
                        <path class="text-white drop-shadow-md" stroke-dasharray="{{ $user->credit_score ?? 85 }}, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" />
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center font-black text-lg">{{ $user->credit_score ?? 85 }}%</div>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-teal-200 uppercase tracking-wider mb-1">{{ __('strings.credit_score_label') ?? 'نقاط الائتمان' }}</p>
                    <p class="text-2xl font-black">{{ $user->credit_rating ?? __('strings.rating_excellent') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        {{-- إجمالي الدين --}}
        <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100 flex flex-col justify-between hover:shadow-md transition duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl"><i data-lucide="wallet" class="w-6 h-6"></i></div>
                <span class="text-[10px] font-bold text-slate-400 bg-slate-50 px-2.5 py-1 rounded-lg border border-slate-100">{{ __('strings.all_time') }}</span>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">{{ __('strings.total_debt_issued') }}</p>
                <h3 class="text-3xl font-black text-slate-800">${{ number_format($totalDebt, 2) }}</h3>
            </div>
        </div>

        {{-- المدفوع --}}
        <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100 flex flex-col justify-between hover:shadow-md transition duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl"><i data-lucide="check-circle-2" class="w-6 h-6"></i></div>
                @php $paidPercentage = $totalDebt > 0 ? round(($totalPaid / $totalDebt) * 100) : 0; @endphp
                <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-100">{{ $paidPercentage }}% {{ __('strings.status_paid') }}</span>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">{{ __('strings.collected') }}</p>
                <h3 class="text-3xl font-black text-slate-800">${{ number_format($totalPaid, 2) }}</h3>
            </div>
        </div>

        {{-- المتبقي --}}
        <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100 flex flex-col justify-between hover:shadow-md transition duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-rose-50 text-rose-600 rounded-2xl"><i data-lucide="pie-chart" class="w-6 h-6"></i></div>
                <span class="text-[10px] font-bold text-rose-600 bg-rose-50 px-2.5 py-1 rounded-lg border border-rose-100">{{ __('strings.active_status') }}</span>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">{{ __('strings.residual_outstanding') }}</p>
                <h3 class="text-3xl font-black text-rose-600">${{ number_format($remainingDebt, 2) }}</h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <div class="lg:col-span-8 space-y-6">
            
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-2">
                    <i data-lucide="zap" class="w-5 h-5 text-amber-500 fill-amber-100"></i>
                    <h2 class="text-xl font-bold text-slate-800">{{ __('strings.company_updates') }}</h2>
                </div>
                <select class="bg-white border border-slate-200 text-xs font-bold text-slate-500 rounded-lg py-2 px-3 focus:outline-none focus:border-teal-500">
                    <option>{{ __('strings.all_companies') ?? 'كل الشركات' }}</option>
                </select>
            </div>

            @forelse($posts as $post)
                <div class="bg-white rounded-[2.5rem] p-6 md:p-8 shadow-sm border border-slate-100 hover:shadow-md transition duration-300 relative overflow-hidden">
                    
                    {{-- رأس المنشور --}}
                    <div class="flex items-center gap-4 mb-5">
                        <div class="w-14 h-14 rounded-2xl bg-slate-50 p-1 border border-slate-100 shadow-sm">
                            <img src="{{ $post->user->avatar ? asset('storage/'.$post->user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($post->user->company_name ?? $post->user->name).'&background=random&size=128' }}" 
                                 class="w-full h-full rounded-xl object-cover" 
                                 alt="Avatar">
                        </div>
                        <div>
                            <h4 class="font-bold text-lg text-slate-900 leading-tight">{{ $post->user->company_name ?? $post->user->name }}</h4>
                            <p class="text-xs text-slate-400 font-medium flex items-center gap-1">
                                <i data-lucide="clock" class="w-3 h-3"></i> {{ $post->created_at->diffForHumans() }}
                            </p>
                        </div>
                        @if($post->is_offer)
                            <div class="mr-auto rtl:mr-0 rtl:ml-auto bg-gradient-to-r from-rose-500 to-pink-500 text-white text-[10px] font-bold px-3 py-1.5 rounded-full shadow-sm flex items-center gap-1">
                                <i data-lucide="percent" class="w-3 h-3"></i> {{ __('strings.special_offer') ?? 'عرض خاص' }}
                            </div>
                        @endif
                    </div>
                    
                    {{-- المحتوى --}}
                    <div class="text-slate-600 text-sm mb-5 leading-loose whitespace-pre-line dir-auto font-medium">
                        {{ $post->content }}
                    </div>

                    {{-- الصورة --}}
                    @if($post->image)
                        <div class="rounded-3xl overflow-hidden mb-5 border border-slate-100 shadow-sm relative group">
                            <img src="{{ asset('storage/' . $post->image) }}" class="w-full h-auto object-cover max-h-[400px]">
                        </div>
                    @endif

                    {{-- التفاعل --}}
                    <div class="flex items-center gap-6 pt-4 border-t border-slate-50">
                        {{-- Like --}}
                        <form action="{{ route('posts.like', $post->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="flex items-center gap-2 px-3 py-1.5 rounded-xl transition-all group {{ $post->isLikedByAuthUser() ? 'bg-rose-50 text-rose-500' : 'hover:bg-slate-50 text-slate-500' }}">
                                <i data-lucide="heart" class="w-5 h-5 transition-transform {{ $post->isLikedByAuthUser() ? 'fill-rose-500 scale-110' : 'group-hover:scale-110' }}"></i> 
                                <span class="text-sm font-bold">{{ $post->likes_count }}</span>
                            </button>
                        </form>

                        {{-- Comment Toggle --}}
                        <button onclick="toggleComments({{ $post->id }})" class="flex items-center gap-2 px-3 py-1.5 rounded-xl hover:bg-teal-50 text-slate-500 hover:text-teal-600 transition-all group">
                            <i data-lucide="message-circle" class="w-5 h-5 group-hover:scale-110 transition-transform"></i> 
                            <span class="text-sm font-bold">{{ $post->comments->count() }} {{ __('strings.comment') }}</span>
                        </button>
                    </div>

                    {{-- قسم التعليقات --}}
                    <div id="comments-section-{{ $post->id }}" class="hidden mt-5 pt-5 border-t border-slate-50 bg-slate-50/50 -mx-6 -mb-6 px-6 pb-6">
                        <div class="space-y-4 mb-5 max-h-60 overflow-y-auto pr-1">
                            @foreach($post->comments->take(5) as $comment)
                                <div class="flex gap-3 items-start group">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name) }}&size=32&background=random" class="w-8 h-8 rounded-full mt-1 ring-2 ring-white shadow-sm">
                                    <div class="bg-white p-3 rounded-2xl rounded-tr-none shadow-sm border border-slate-100 text-xs flex-1">
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="font-bold text-slate-800">{{ $comment->user->name }}</span>
                                            <span class="text-[10px] text-slate-400">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-slate-600 leading-relaxed">{{ $comment->content }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- إضافة تعليق --}}
                        <form action="{{ route('posts.comment', $post->id) }}" method="POST" class="flex gap-2 items-center relative">
                            @csrf
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=32&background=random" class="w-9 h-9 rounded-full border border-slate-200 shadow-sm">
                            <div class="relative flex-1">
                                <input type="text" name="content" placeholder="{{ __('strings.write_comment') ?? 'اكتب تعليقاً...' }}" class="w-full bg-white border border-slate-200 rounded-full pl-4 pr-12 py-2.5 text-xs focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-100 transition shadow-sm" required>
                                <button type="submit" class="absolute left-1.5 rtl:left-auto rtl:right-1.5 top-1.5 bottom-1.5 bg-teal-600 text-white w-8 h-8 rounded-full flex items-center justify-center hover:bg-teal-700 transition shadow-md hover:scale-105 active:scale-95">
                                    <i data-lucide="send" class="w-3.5 h-3.5 rtl:rotate-180"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-16 bg-white rounded-[2.5rem] border border-dashed border-slate-200">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                        <i data-lucide="newspaper" class="w-10 h-10"></i>
                    </div>
                    <h3 class="text-slate-800 font-bold text-lg mb-2">{{ __('strings.no_updates') ?? 'لا توجد تحديثات حالياً' }}</h3>
                </div>
            @endforelse
        </div>

        <div class="lg:col-span-4 space-y-6 lg:sticky lg:top-24">
            
            {{-- البحث --}}
            <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100">
                <h4 class="text-xs font-bold text-slate-400 uppercase mb-4 flex items-center gap-2 border-l-4 border-teal-500 pl-3 rtl:pl-0 rtl:pr-3 rtl:border-l-0 rtl:border-r-4">
                     {{ __('strings.find_provider') }}
                </h4>
                <div class="relative group">
                    <input type="text" placeholder="{{ __('strings.search_companies') }}" class="w-full bg-slate-50 border-none rounded-xl text-sm py-3.5 px-4 focus:outline-none focus:ring-2 focus:ring-teal-500/20 text-slate-600 transition">
                    <button class="absolute left-2 rtl:left-auto rtl:right-2 top-2 bottom-2 w-9 h-9 bg-white rounded-lg shadow-sm flex items-center justify-center text-teal-500 hover:bg-teal-50 transition">
                         <i data-lucide="search" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>

            {{-- مزودي الخدمة --}}
            <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100">
                <div class="flex justify-between items-center mb-6 border-l-4 border-indigo-500 pl-3 rtl:pl-0 rtl:pr-3 rtl:border-l-0 rtl:border-r-4">
                    <h4 class="text-xs font-bold text-slate-400 uppercase">
                        {{ __('strings.my_providers') }}
                    </h4>
                    <a href="{{ route('debtor.debts') }}" class="text-[10px] font-bold text-indigo-500 hover:bg-indigo-50 px-2 py-1 rounded-md transition">{{ __('strings.view_all') }}</a>
                </div>
                
                <div class="space-y-3">
                    @forelse($recentActivities as $debt)
                        <div class="flex items-center justify-between p-3 hover:bg-slate-50 rounded-2xl transition cursor-pointer group border border-transparent hover:border-slate-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-sm shadow-sm group-hover:scale-105 transition">
                                    {{ substr($debt->creditor->company_name ?? $debt->creditor->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-700 group-hover:text-indigo-600 transition">
                                        {{ $debt->creditor->company_name ?? $debt->creditor->name }}
                                    </p>
                                    <p class="text-[10px] text-slate-400 font-medium">
                                        {{ __('strings.debt_label') ?? 'الدين' }}: ${{ number_format($debt->remaining_amount, 2) }}
                                    </p>
                                </div>
                            </div>
                            <span class="w-2.5 h-2.5 {{ $debt->remaining_amount > 0 ? 'bg-rose-500 shadow-rose-200' : 'bg-emerald-500 shadow-emerald-200' }} rounded-full shadow-lg border-2 border-white"></span>
                        </div>
                    @empty
                        <div class="text-center py-6">
                            <p class="text-xs text-slate-400">{{ __('strings.no_debts') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- الأدوات --}}
            <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100">
                 <h4 class="text-xs font-bold text-slate-400 uppercase mb-4 flex items-center gap-2 border-l-4 border-orange-500 pl-3 rtl:pl-0 rtl:pr-3 rtl:border-l-0 rtl:border-r-4">
                    {{ __('strings.tools') }}
                 </h4>
                 <button onclick="openCalculator()" class="w-full flex items-center p-3.5 bg-gradient-to-r from-slate-50 to-white border border-slate-100 hover:border-teal-200 hover:from-teal-50/50 rounded-2xl transition group text-right">
                    <div class="w-10 h-10 rounded-xl bg-teal-100 shadow-sm flex items-center justify-center ml-3 rtl:mr-0 rtl:ml-3 text-teal-600 group-hover:scale-110 group-hover:rotate-3 transition">
                        <i data-lucide="calculator" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <span class="block text-sm font-bold text-slate-700 group-hover:text-teal-700 transition">{{ __('strings.installment_calc') }}</span>
                    </div>
                </button>
            </div>

        </div>
    </div>
</main>

<div id="calculatorModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity duration-300">
    <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-sm p-8 relative scale-95 opacity-0 transition-all duration-300 transform" id="calcContent">
        <button onclick="closeCalculator()" class="absolute top-6 right-6 rtl:right-auto rtl:left-6 p-2 bg-slate-50 hover:bg-rose-50 text-slate-400 hover:text-rose-500 rounded-full transition">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
        
        <div class="text-center mb-6">
            <div class="w-14 h-14 bg-teal-50 text-teal-600 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-sm">
                <i data-lucide="calculator" class="w-7 h-7"></i>
            </div>
            <h3 class="text-xl font-black text-slate-800">{{ __('strings.installment_calc') }}</h3>
        </div>

        <div class="space-y-4">
            <div>
                <label class="text-xs font-bold text-slate-500 pr-1 rtl:pl-1">{{ __('strings.total_amount') ?? 'المبلغ الإجمالي' }}</label>
                <div class="relative mt-1">
                    <span class="absolute right-4 rtl:left-4 rtl:right-auto top-3.5 text-slate-400 text-sm">$</span>
                    <input type="number" id="totalAmount" class="w-full bg-slate-50 border-none rounded-2xl p-3.5 pr-8 rtl:pl-8 text-slate-800 font-bold focus:ring-2 focus:ring-teal-500/20 transition" placeholder="0.00">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-bold text-slate-500 pr-1 rtl:pl-1">{{ __('strings.down_payment') ?? 'الدفعة الأولى' }}</label>
                    <input type="number" id="downPayment" class="w-full bg-slate-50 border-none rounded-2xl p-3.5 mt-1 text-slate-800 font-bold focus:ring-2 focus:ring-teal-500/20 transition" placeholder="0.00">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-500 pr-1 rtl:pl-1">{{ __('strings.months') ?? 'الأشهر' }}</label>
                    <input type="number" id="months" class="w-full bg-slate-50 border-none rounded-2xl p-3.5 mt-1 text-slate-800 font-bold focus:ring-2 focus:ring-teal-500/20 transition" value="12">
                </div>
            </div>
            
            <div id="calcResult" class="hidden bg-gradient-to-br from-teal-50 to-emerald-50 p-5 rounded-2xl text-center border border-teal-100 mt-2">
                <p class="text-xs text-teal-600 font-bold mb-1">{{ __('strings.monthly_installment') ?? 'القسط الشهري' }}</p>
                <p class="text-3xl font-black text-teal-700" id="monthlyResult">$0.00</p>
            </div>

            <button onclick="calculateInstallment()" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-teal-200 transition active:scale-95 mt-2">
                {{ __('strings.calculate') ?? 'احسب' }}
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/debtorLog.js') }}"></script>
@endpush