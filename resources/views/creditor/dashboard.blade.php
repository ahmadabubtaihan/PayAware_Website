@extends('layouts.creditorNItems')

@section('title', __('strings.dashboard') . ' | PayAware')

@section('content')
    <main class="pt-28 pb-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">

        {{-- ======================== --}}
        {{--  التنبيهات --}}
        {{-- ======================== --}}
        @if (session('success'))
            <div class="mb-6 p-4 rounded-xl bg-teal-50 border border-teal-200 text-teal-700 flex items-center gap-3 shadow-sm" role="alert">
                <div class="p-2 bg-teal-100 rounded-full text-teal-600">
                    <i data-lucide="check" class="w-5 h-5"></i>
                </div>
                <div>
                    <span class="font-bold block">{{ __('strings.success') }}</span>
                    <span class="text-sm">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 flex items-center gap-3 shadow-sm" role="alert">
                <div class="p-2 bg-red-100 rounded-full text-red-600">
                    <i data-lucide="x-circle" class="w-5 h-5"></i>
                </div>
                <div>
                    <span class="font-bold block">{{ __('strings.error') }}</span>
                    <span class="text-sm">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 shadow-sm">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ======================== --}}
        {{-- الهيدر و التقارير  --}}
        {{-- ======================== --}}
        <div class="flex flex-col md:flex-row justify-between items-end md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-800">{{ __('strings.dashboard_overview') }}</h1>
                <p class="text-sm text-slate-500">{{ __('strings.dashboard_desc_full') }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('creditor.report', ['type' => 'daily']) }}" target="_blank" class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 transition shadow-sm font-bold text-sm">
                    <i data-lucide="file-text" class="w-4 h-4"></i> {{ __('strings.daily_report') }}
                </a>
                <a href="{{ route('creditor.report', ['type' => 'monthly']) }}" target="_blank" class="flex items-center gap-2 px-4 py-2 bg-slate-800 text-white rounded-xl hover:bg-slate-700 transition shadow-md font-bold text-sm">
                    <i data-lucide="calendar" class="w-4 h-4"></i> {{ __('strings.monthly_report') }}
                </a>
            </div>
        </div>
        
        {{-- ======================== --}}
        {{-- للحالات --}}
        {{-- ======================== --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between group hover:shadow-md transition">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">{{ __('strings.total_debt_issued') }}</p>
                    <h3 class="text-2xl font-extrabold text-slate-800 mt-1">${{ number_format($totalDebtIssued, 2) }}</h3>
                    <p class="text-xs text-red-500 font-semibold mt-1 flex items-center gap-1">
                        <i data-lucide="trending-up" class="w-3 h-3"></i> {{ __('strings.given_this_month') }}
                    </p>
                </div>
                <div class="w-12 h-12 rounded-full bg-red-50 text-red-500 flex items-center justify-center group-hover:bg-red-500 group-hover:text-white transition">
                    <i data-lucide="minus-circle" class="w-6 h-6"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between group hover:shadow-md transition">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">{{ __('strings.total_repayment') }}</p>
                    <h3 class="text-2xl font-extrabold text-teal-600 mt-1">${{ number_format($totalRepayment, 2) }}</h3>
                    <p class="text-xs text-teal-500 font-semibold mt-1 flex items-center gap-1">
                        <i data-lucide="check-circle" class="w-3 h-3"></i> {{ __('strings.collected') }}
                    </p>
                </div>
                <div class="w-12 h-12 rounded-full bg-teal-50 text-teal-600 flex items-center justify-center group-hover:bg-teal-500 group-hover:text-white transition">
                    <i data-lucide="plus-circle" class="w-6 h-6"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between group hover:shadow-md transition">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">{{ __('strings.residual_outstanding') }}</p>
                    <h3 class="text-2xl font-extrabold text-indigo-600 mt-1">${{ number_format($residualOutstanding, 2) }}</h3>
                    <p class="text-xs text-slate-400 font-semibold mt-1">{{ __('strings.active_accounts_count', ['count' => $activeAccountsCount]) }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-indigo-50 text-indigo-500 flex items-center justify-center group-hover:bg-indigo-500 group-hover:text-white transition">
                    <i data-lucide="wallet" class="w-6 h-6"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between group hover:shadow-md transition">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">{{ __('strings.active_warnings') }}</p>
                    <h3 class="text-2xl font-extrabold text-slate-800 mt-1">{{ $activeWarnings }}</h3>
                    <p class="text-xs text-orange-500 font-semibold mt-1">{{ __('strings.sent_to_debtors') }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-orange-50 text-orange-500 flex items-center justify-center group-hover:bg-orange-500 group-hover:text-white transition">
                    <i data-lucide="alert-triangle" class="w-6 h-6"></i>
                </div>
            </div>
        </div>

        {{-- ============================== --}}
        {{-- للسيرش  --}}
        {{-- ============================== --}}
        <div class="bg-gradient-to-r from-slate-800 to-slate-900 rounded-[2rem] p-8 shadow-lg mb-8 text-white relative overflow-hidden rtl:from-slate-900 rtl:to-slate-800">
            <div class="absolute top-0 right-0 rtl:right-auto rtl:left-0 w-64 h-64 bg-teal-500/10 rounded-full blur-3xl -mr-16 rtl:-ml-16 -mt-16"></div>
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <h3 class="text-xl font-bold flex items-center gap-2 mb-2">
                        <i data-lucide="shield-check" class="w-6 h-6 text-teal-400"></i> {{ __('strings.debtor_credit_check') }}
                    </h3>
                    <p class="text-slate-300 text-sm max-w-xl">
                        {{ __('strings.credit_check_desc') }}
                    </p>
                </div>
                
                {{-- نموذج البحث --}}
                <form action="{{ route('creditor.search') }}" method="GET" class="w-full md:w-auto flex gap-2">
                    <input type="text" 
                           name="query" 
                           required
                           placeholder="{{ __('strings.search_id_phone_placeholder') }}" 
                           class="w-full md:w-80 bg-slate-700/50 border border-slate-600 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-teal-400 focus:ring-1 focus:ring-teal-400 placeholder-slate-400">
                    
                    <button type="submit" class="px-6 py-3 bg-teal-500 hover:bg-teal-400 text-white font-bold rounded-xl transition shadow-lg shadow-teal-500/20">
                        {{ __('strings.search_btn') }}
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <div class="lg:col-span-8 space-y-8">
                
                {{-- ================================= --}}
                {{-- شارت التحلييل     --}}
                {{-- ================================= --}}
                <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2">
                                <i data-lucide="bar-chart-2" class="w-5 h-5 text-teal-500"></i> {{ __('strings.analytics_title') }}
                            </h3>
                            <p class="text-xs text-slate-400 mt-1">{{ __('strings.debts_vs_repayments') }}</p>
                        </div>
                        <div class="flex gap-2">
                            <button class="px-3 py-1 text-xs font-bold bg-slate-100 text-slate-600 rounded-lg hover:bg-slate-200 transition">{{ __('strings.weekly') }}</button>
                        </div>
                    </div>
                    <div class="w-full h-64 relative">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
                
                {{-- ================================= --}}
                {{-- التسجيلات الاخيرة  --}}
                {{-- ================================= --}}
                <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-slate-800 text-lg">{{ __('strings.recent_records') }}</h3>
                        <a href="{{ route('creditor.history') }}" class="text-xs font-bold text-teal-600 hover:text-teal-700">{{ __('strings.view_all_records') }}</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left rtl:text-right border-collapse">
                            <thead>
                                <tr class="text-xs text-slate-400 border-b border-slate-100">
                                    <th class="py-3 font-bold uppercase tracking-wider">{{ __('strings.debtor') }}</th>
                                    <th class="py-3 font-bold uppercase tracking-wider">{{ __('strings.transaction') }}</th>
                                    <th class="py-3 font-bold uppercase tracking-wider">{{ __('strings.date') }}</th>
                                    <th class="py-3 font-bold uppercase tracking-wider text-right rtl:text-left">{{ __('strings.value') }}</th>
                                    <th class="py-3 font-bold uppercase tracking-wider text-center">{{ __('strings.action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                @forelse($recentRecords as $record)
                                    @php
                                        $debtor = ($record->record_type == 'debt') ? $record->debtor : ($record->debt->debtor ?? null);
                                        $debtorName = $debtor ? $debtor->name : __('strings.unknown');
                                        $debtorId = $debtor ? $debtor->id : '-';
                                    @endphp
                                    <tr class="group hover:bg-slate-50 transition border-b border-slate-50">
                                        <td class="py-4 flex items-center gap-3">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($debtorName) }}&background=random&color=fff" class="w-8 h-8 rounded-full bg-slate-100">
                                            <div>
                                                <span class="font-bold text-slate-700 block">{{ $debtorName }}</span>
                                                <span class="text-[10px] text-slate-400">ID: {{ $debtorId }}</span>
                                            </div>
                                        </td>
                                        <td class="py-4 text-slate-500">
                                            {{ $record->record_type == 'debt' ? __('strings.new_debt_product') : __('strings.repayment_installment') }}
                                        </td>
                                        <td class="py-4 text-slate-500">{{ $record->created_at->format('M d, Y') }}</td>
                                        <td class="py-4 text-right rtl:text-left font-bold {{ $record->record_type == 'payment' ? 'text-teal-600' : 'text-red-500' }}">
                                            {{ $record->record_type == 'payment' ? '+' : '-' }}${{ number_format($record->amount, 2) }}
                                        </td>
                                        <td class="py-4 text-center">
                                            <button class="text-slate-400 hover:text-indigo-600"><i data-lucide="eye" class="w-4 h-4"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-8 text-center text-slate-400 text-sm">
                                            {{ __('strings.no_records_found') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ============================ --}}
                {{-- البوستات --}}
                {{-- ============================ --}}
                <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100">
                    
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                                <span class="w-1.5 h-6 bg-teal-500 rounded-full"></span>
                                {{ __('strings.company_posts') }}
                            </h3>
                        </div>
                        <button onclick="toggleModal('createPostModal')" class="group flex items-center gap-2 bg-slate-800 hover:bg-slate-700 text-white px-3 py-2 rounded-xl transition shadow-md shadow-slate-200">
                            <i data-lucide="plus" class="w-3.5 h-3.5 group-hover:scale-110 transition"></i>
                            <span class="text-xs font-bold">{{ __('strings.new_post') }}</span>
                        </button>
                    </div>

                    <div class="space-y-4 max-h-[500px] overflow-y-auto pr-1">
                        @forelse($companyPosts as $post)
                            <div class="border border-slate-100 rounded-2xl overflow-hidden hover:shadow-md transition duration-300 group bg-slate-50/30">
                                <div class="p-3 flex items-center justify-between bg-white border-b border-slate-50">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ ($user->company && $user->company->logo) ? asset('storage/' . $user->company->logo) : 'https://api.dicebear.com/7.x/identicon/svg?seed=' . ($user->company->name ?? $user->name) }}" class="w-9 h-9 rounded-full bg-slate-100 border border-slate-100 object-cover">
                                        <div>
                                            <h4 class="font-bold text-slate-800 text-sm">{{ $user->company->name ?? $user->name }}</h4>
                                            <p class="text-[10px] text-slate-400 font-medium flex items-center gap-1">
                                                <i data-lucide="globe" class="w-3 h-3"></i> {{ $post->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="relative">
                                        <button onclick="toggleDropdown('post-menu-{{ $post->id }}')" class="p-1.5 hover:bg-slate-100 rounded-full text-slate-400 hover:text-slate-600 transition">
                                            <i data-lucide="more-horizontal" class="w-5 h-5"></i>
                                        </button>
                                        <div id="post-menu-{{ $post->id }}" class="hidden absolute right-0 rtl:right-auto rtl:left-0 mt-2 w-36 bg-white rounded-xl shadow-xl border border-slate-100 py-1 z-20">
                                            <button class="w-full text-left rtl:text-right px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-50 flex items-center gap-2">
                                                <i data-lucide="edit-3" class="w-3 h-3"></i> {{ __('strings.edit') }}
                                            </button>
                                            <button class="w-full text-left rtl:text-right px-4 py-2 text-xs font-bold text-red-500 hover:bg-red-50 flex items-center gap-2">
                                                <i data-lucide="trash-2" class="w-3 h-3"></i> {{ __('strings.delete') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-3">
                                    <p class="text-sm text-slate-600 leading-relaxed mb-3 whitespace-pre-line">{{ $post->content }}</p>
                                    @if($post->image)
                                    <div class="rounded-xl overflow-hidden h-40 w-full relative group/image">
                                        <img src="{{ asset('storage/' . $post->image) }}" class="w-full h-full object-cover transition duration-700 group-hover/image:scale-105">
                                    </div>
                                    @endif
                                </div>
                                <div class="px-4 py-2 bg-white border-t border-slate-100 flex items-center justify-between">
                                    <div class="flex gap-4">
                                        <div class="flex items-center gap-1.5 text-slate-500">
                                            <i data-lucide="heart" class="w-3.5 h-3.5 {{ $post->likes_count > 0 ? 'text-red-500 fill-red-500' : '' }}"></i>
                                            <span class="text-xs font-bold">{{ $post->likes_count }}</span>
                                        </div>
                                        <button class="flex items-center gap-1.5 text-slate-500 hover:text-teal-600 transition">
                                            <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                                            <span class="text-xs font-bold">{{ $post->comments_count }}</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-6 text-slate-400 text-sm">
                                {{ __('strings.no_posts_yet') }}
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

            <div class="lg:col-span-4 space-y-8">
                
                {{-- حركات المدين --}}
                <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100 sticky top-28">
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-6 border-l-4 rtl:border-l-0 rtl:border-r-4 border-teal-500 pl-3 rtl:pl-0 rtl:pr-3">{{ __('strings.creditor_actions') }}</h3>
                    
                    <div class="space-y-4">
                        <button onclick="toggleModal('addDebtModal')" class="w-full flex items-center p-4 bg-[#F8FAFC] hover:bg-red-50 rounded-xl transition group text-left rtl:text-right border border-transparent hover:border-red-100 hover:shadow-md">
                            <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center mr-4 rtl:mr-0 rtl:ml-4 group-hover:bg-red-500 group-hover:text-white transition shadow-sm">
                                <i data-lucide="minus-circle" class="w-5 h-5 font-bold"></i>
                            </div>
                            <div>
                                <span class="block text-sm font-bold text-slate-700">{{ __('strings.add_debt') }}</span>
                                <span class="text-[10px] text-slate-400">{{ __('strings.record_new_liability') }}</span>
                            </div>
                        </button>

                        <button onclick="toggleModal('addPaymentModal')" class="w-full flex items-center p-4 bg-[#F8FAFC] hover:bg-teal-50 rounded-xl transition group text-left rtl:text-right border border-transparent hover:border-teal-100 hover:shadow-md">
                            <div class="w-10 h-10 rounded-full bg-teal-100 text-teal-600 flex items-center justify-center mr-4 rtl:mr-0 rtl:ml-4 group-hover:bg-teal-500 group-hover:text-white transition shadow-sm">
                                <i data-lucide="plus-circle" class="w-5 h-5 font-bold"></i>
                            </div>
                            <div>
                                <span class="block text-sm font-bold text-slate-700">{{ __('strings.add_payment') }}</span>
                                <span class="text-[10px] text-slate-400">{{ __('strings.record_installment') }}</span>
                            </div>
                        </button>
                        
                        <button onclick="toggleModal('addUserModal')" class="w-full flex items-center p-4 bg-[#F8FAFC] hover:bg-indigo-50 rounded-xl transition group text-left rtl:text-right border border-transparent hover:border-indigo-100 hover:shadow-md">
                            <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center mr-4 rtl:mr-0 rtl:ml-4 group-hover:bg-indigo-500 group-hover:text-white transition shadow-sm">
                                <i data-lucide="user-plus" class="w-5 h-5 font-bold"></i>
                            </div>
                            <div>
                                <span class="block text-sm font-bold text-slate-700">{{ __('strings.create_record') }}</span>
                                <span class="text-[10px] text-slate-400">{{ __('strings.new_debtor_profile') }}</span>
                            </div>
                        </button>

                        <button onclick="toggleModal('warningModal')" class="w-full flex items-center p-4 bg-[#F8FAFC] hover:bg-orange-50 rounded-xl transition group text-left rtl:text-right border border-transparent hover:border-orange-100 hover:shadow-md">
                            <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center mr-4 rtl:mr-0 rtl:ml-4 group-hover:bg-orange-500 group-hover:text-white transition shadow-sm">
                                <i data-lucide="bell-off" class="w-5 h-5 font-bold"></i>
                            </div>
                            <div>
                                <span class="block text-sm font-bold text-slate-700">{{ __('strings.add_warning') }}</span>
                                <span class="text-[10px] text-slate-400">{{ __('strings.send_late_payment_alert') }}</span>
                            </div>
                        </button>
                    </div>

                    {{-- أعلى الدافعين  --}}
                    <div class="mt-8 pt-6 border-t border-slate-50">
                        <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4 border-l-4 rtl:border-l-0 rtl:border-r-4 border-indigo-500 pl-3 rtl:pl-0 rtl:pr-3">{{ __('strings.top_payers') }}</h3>
                        <div class="space-y-4">
                            @forelse($topPayers as $index => $payer)
                                <div class="flex items-center gap-3 p-2 hover:bg-slate-50 rounded-xl transition cursor-pointer group">
                                    <div class="relative">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($payer->debtor->name ?? 'User') }}&background=random&color=fff" 
                                             class="w-10 h-10 rounded-full bg-slate-100 group-hover:scale-110 transition shadow-sm">
                                        
                                        <div class="absolute -bottom-1 -right-1 rtl:right-auto rtl:-left-1 w-5 h-5 flex items-center justify-center bg-yellow-400 text-[10px] rounded-full text-white font-bold border-2 border-white shadow-sm">
                                            {{ $index + 1 }}
                                        </div>
                                    </div>
                                    
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-bold text-slate-800 truncate">{{ $payer->debtor->name ?? __('strings.unknown') }}</p>
                                        <div class="flex items-center gap-1">
                                            <div class="w-12 h-1 bg-slate-100 rounded-full overflow-hidden">
                                                <div class="h-full bg-teal-500 rounded-full" style="width: {{ $payer->rating }}%"></div>
                                            </div>
                                            <span class="text-[10px] text-slate-400">{{ __('strings.rating_excellent') }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="text-right rtl:text-left">
                                        <span class="block text-xs text-teal-600 font-bold">{{ $payer->rating }}%</span>
                                        <span class="block text-[9px] text-slate-400">${{ number_format($payer->total_paid) }}</span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <p class="text-xs text-slate-400">{{ __('strings.no_records_found') }}</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- تريجر الشات و هو غير فعال الان --}}
    <div class="fixed bottom-6 right-6 z-50" >
        <button onclick="toggleModal('chatModal')" class="flex items-center justify-center w-14 h-14 bg-indigo-600 text-white rounded-full shadow-2xl hover:bg-indigo-700 transition transform hover:scale-110">
            <i data-lucide="message-square" class="w-7 h-7"></i>
        </button>
    </div>

    @include('creditor.modals.add_debt')
    @include('creditor.modals.add_payment')
    @include('creditor.modals.add_debtor')
    @include('creditor.modals.send_warning')


    
    {{-- موديل للبوست قيد التجربة --}}
    <div id="createPostModal" class="fixed inset-0 z-[100] hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="toggleModal('createPostModal')"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative transform overflow-hidden rounded-3xl bg-white text-left rtl:text-right shadow-2xl transition-all w-full max-w-xl border border-slate-100">
<form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="flex gap-4 mb-4">
        <img src="{{ Auth::user()->avatar ? asset('storage/'.Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name) }}" class="w-10 h-10 rounded-full bg-slate-100 object-cover">
        <textarea name="content" rows="2" placeholder="{{ __('strings.whats_on_your_mind', ['name' => Auth::user()->name]) }}" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition resize-none"></textarea>
    </div>
    
    <div class="flex justify-between items-center pt-3 border-t border-slate-50">
        <div class="flex gap-4">
            <label class="flex items-center gap-2 text-slate-500 hover:text-indigo-600 text-xs font-bold transition cursor-pointer">
                <input type="file" name="image" class="hidden" accept="image/*">
                <i data-lucide="image" class="w-4 h-4"></i> {{ __('strings.add_image') }}
            </label>
            <label class="flex items-center gap-2 text-slate-500 hover:text-indigo-600 text-xs font-bold transition cursor-pointer">
                <input type="checkbox" name="is_offer" class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500 border-gray-300">
                <span class="ml-2">{{ __('strings.promotional_offer') }}</span>
            </label>
        </div>
        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg text-xs transition shadow-md shadow-indigo-200">
            {{ __('strings.post_action') }}
        </button>
    </div>
</form>
                </div>
            </div>
        </div>
    </div>

    {{-- موديل للشات قيد التجربة --}}
    <div id="chatModal" class="fixed inset-0 z-[100] hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="toggleModal('chatModal')"></div>
        <div class="fixed inset-0 z-10 overflow-hidden flex justify-end rtl:justify-start">
            <div class="w-full max-w-md h-full bg-white shadow-2xl flex flex-col">
                <div class="p-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                    <h3 class="font-bold text-slate-800">{{ __('strings.inbox') }}</h3>
                    <button onclick="toggleModal('chatModal')" class="p-2 hover:bg-slate-200 rounded-full"><i data-lucide="x" class="w-5 h-5"></i></button>
                </div>
                <div class="flex-1 overflow-y-auto p-4 space-y-4">
                    <div class="flex items-center gap-3 p-3 hover:bg-slate-50 rounded-xl cursor-pointer">
                        <img src="https://cdn0.iconfinder.com/data/icons/user-pictures/100/unknown-512.png" class="w-10 h-10 rounded-full bg-slate-100">
                        <div class="flex-1">
                            <h4 class="text-sm font-bold text-slate-800">Ahmed Ali</h4>
                            <p class="text-xs text-slate-500 truncate">When is my next payment due?</p>
                        </div>
                        <span class="text-[10px] text-slate-400">10m</span>
                    </div>
                </div>
                <div class="p-4 border-t border-slate-100">
                    <button class="w-full py-3 bg-indigo-600 text-white rounded-xl font-bold text-sm">{{ __('strings.new_message') }}</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
{{-- استدعاء مكتبة Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('revenueChart').getContext('2d');

        // إعداد التدرجات اللونية 
        let gradientDebt = ctx.createLinearGradient(0, 0, 0, 400);
        gradientDebt.addColorStop(0, 'rgba(99, 102, 241, 0.5)'); 
        gradientDebt.addColorStop(1, 'rgba(99, 102, 241, 0.0)');

        let gradientRepay = ctx.createLinearGradient(0, 0, 0, 400);
        gradientRepay.addColorStop(0, 'rgba(20, 184, 166, 0.5)'); 
        gradientRepay.addColorStop(1, 'rgba(20, 184, 166, 0.0)');

        // البيانات 
        const labels = ['Sat', 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri'];
        
        const dataDebts = {!! json_encode($chartDebts ?? [1200, 1900, 300, 500, 200, 300, 900]) !!}; 
        const dataRepayments = {!! json_encode($chartRepayments ?? [800, 1200, 1000, 800, 500, 600, 1200]) !!};

        //  إنشاء الشارت
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: '{{ __("strings.total_debt_issued") }}',
                        data: dataDebts,
                        borderColor: '#6366f1',
                        backgroundColor: gradientDebt,
                        borderWidth: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#6366f1',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: '{{ __("strings.total_repayment") }}',
                        data: dataRepayments,
                        borderColor: '#14b8a6', 
                        backgroundColor: gradientRepay,
                        borderWidth: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#14b8a6',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end',
                        labels: {
                            font: {
                                family: "'Cairo', 'Plus Jakarta Sans', sans-serif",
                                size: 12
                            },
                            usePointStyle: true,
                            boxWidth: 8
                        }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(255, 255, 255, 0.9)',
                        titleColor: '#1e293b',
                        bodyColor: '#475569',
                        borderColor: '#e2e8f0',
                        borderWidth: 1,
                        titleFont: { family: "'Cairo', sans-serif", size: 13, weight: 'bold' },
                        bodyFont: { family: "'Cairo', sans-serif", size: 12 },
                        padding: 12,
                        displayColors: true,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            font: { family: "'Cairo', sans-serif" },
                            color: '#94a3b8'
                        }
                    },
                    y: {
                        grid: {
                            color: '#f1f5f9',
                            borderDash: [5, 5],
                            drawBorder: false
                        },
                        ticks: {
                            font: { family: "'Cairo', sans-serif" },
                            color: '#94a3b8',
                            callback: function(value) {
                                return '$' + value;
                            }
                        }
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                }
            }
        });
    });
</script>

<script src="{{ asset('js/creditorLog.js') }}"></script>
@endpush