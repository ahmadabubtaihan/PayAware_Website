@extends('layouts.creditorNItems')

@section('title', __('strings.all_debtors_title') . ' | PayAware')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/creditorStyle.css') }}">
@endpush

@section('content')

    @php
        function getStatusColorClass($status) {
            return match($status) {
                'low' => 'bg-green-500',
                'medium' => 'bg-yellow-500',
                'high' => 'bg-red-500',
                default => 'bg-slate-500'
            };
        }
        
        function getStatusLabelText($status) {
            return match($status) {
                'low' => __('strings.low_risk'),
                'medium' => __('strings.medium_risk'),
                'high' => __('strings.high_risk'),
                default => 'Unknown'
            };
        }
    @endphp

    <main class="pt-28 pb-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        
        {{--  الإحصائيات السريعة --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            {{-- إجمالي المستحقات --}}
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 rounded-[2rem] p-6 text-white shadow-lg shadow-teal-100 relative overflow-hidden rtl:bg-gradient-to-l">
                <div class="relative z-10">
                    <p class="text-teal-100 text-sm font-bold mb-1 uppercase tracking-wider">{{ __('strings.total_receivables') }}</p>
                    <h3 class="text-3xl font-black">${{ number_format($totalReceivables, 2) }}</h3>
                </div>
                <i data-lucide="wallet" class="absolute right-4 rtl:right-auto rtl:left-4 bottom-4 w-16 h-16 text-white opacity-20"></i>
            </div>
            
            {{-- المدينون ذوو المخاطر العالية --}}
            <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-sm flex items-center justify-between group hover:border-red-200 transition">
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">{{ __('strings.high_risk_debtors') }}</p>
                    <h3 class="text-2xl font-black text-red-500 mt-1">{{ $highRiskCount }} {{ __('strings.user_col') }}</h3>
                </div>
                <div class="w-12 h-12 bg-red-50 rounded-full flex items-center justify-center text-red-500 group-hover:bg-red-500 group-hover:text-white transition">
                    <i data-lucide="alert-circle" class="w-6 h-6"></i>
                </div>
            </div>
            
            {{-- التحصيلات هذا الشهر --}}
            <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-sm flex items-center justify-between group hover:border-indigo-200 transition">
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">{{ __('strings.collected_this_month') }}</p>
                    <h3 class="text-2xl font-black text-slate-800 mt-1">${{ number_format($collectedThisMonth, 2) }}</h3>
                </div>
                <div class="w-12 h-12 bg-indigo-50 rounded-full flex items-center justify-center text-indigo-500 group-hover:bg-indigo-500 group-hover:text-white transition">
                    <i data-lucide="trending-up" class="w-6 h-6"></i>
                </div>
            </div>
        </div>

        {{-- البحث والفلترة --}}
        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100 mb-8">
            <div class="flex items-center gap-2 mb-4">
                <div class="w-1 h-6 bg-teal-500 rounded-full"></div>
                <h2 class="text-lg font-bold text-slate-800">{{ __('strings.filter_search_debtors') }}</h2>
            </div>
            
            <form action="{{ route('creditor.debtors') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="relative min-w-[200px]">
                    <select name="status" class="w-full bg-slate-50 border-none rounded-xl py-3 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500/20 text-slate-600 cursor-pointer font-bold rtl:bg-left" onchange="this.form.submit()">
                        <option value="">{{ __('strings.all_risks_status') }}</option>
                        <option value="high" {{ request('status') == 'high' ? 'selected' : '' }}>🔴 {{ __('strings.high_risk') }}</option>
                        <option value="medium" {{ request('status') == 'medium' ? 'selected' : '' }}>🟡 {{ __('strings.medium_risk') }}</option>
                        <option value="low" {{ request('status') == 'low' ? 'selected' : '' }}>🟢 {{ __('strings.low_risk') }}</option>
                    </select>
                    <i data-lucide="filter" class="absolute right-3 rtl:right-auto rtl:left-3 top-3 w-5 h-5 text-slate-400 pointer-events-none"></i>
                </div>

                <div class="flex-1 relative">
                    <input type="text" name="query" value="{{ request('query') }}" placeholder="{{ __('strings.search_placeholder_debtors') }}" class="w-full bg-slate-50 border-none rounded-xl py-3 pl-10 pr-4 rtl:pr-10 rtl:pl-4 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500/20 text-slate-600 placeholder-slate-400 font-medium">
                    <i data-lucide="search" class="absolute left-3 rtl:left-auto rtl:right-3 top-3 w-5 h-5 text-slate-400"></i>
                </div>
                
                <button type="submit" class="bg-[#10B981] hover:bg-teal-600 text-white font-bold px-8 py-3 rounded-xl shadow-lg shadow-teal-200 transition transform active:scale-95 flex items-center justify-center gap-2">
                    <i data-lucide="search" class="w-4 h-4"></i> {{ __('strings.search_btn') }}
                </button>

                @if(request()->has('query') || request()->has('status'))
                    <a href="{{ route('creditor.debtors') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-600 font-bold px-4 py-3 rounded-xl transition flex items-center justify-center">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </a>
                @endif
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            {{--القائمة الرئيسية  --}}
            <div class="lg:col-span-8">
                <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100 min-h-[600px]">
                    
                    <div class="flex justify-between items-center mb-8 flex-wrap gap-4">
                        <div class="flex items-center gap-2">
                            <div class="w-1 h-6 bg-teal-500 rounded-full"></div>
                            <h2 class="text-lg font-bold text-slate-800">{{ __('strings.all_debtors_title') }}</h2>
                            <span class="text-xs font-bold text-slate-400 bg-slate-100 px-2 py-1 rounded-lg">{{ $debtors->total() }}</span>
                        </div>
                        <div class="flex gap-3">
                            <button onclick="window.print()" class="flex items-center gap-2 bg-slate-50 hover:text-slate-700 text-slate-500 px-4 py-2.5 rounded-xl font-bold text-xs transition active:scale-95 border border-slate-100">
                                <i data-lucide="printer" class="w-4 h-4"></i> {{ __('strings.print_list') }}
                            </button>
                        </div>
                    </div>

                    <div class="overflow-x-auto custom-scroll pb-4">
                        <table class="w-full min-w-[700px] text-left rtl:text-right">
                            <thead>
                                <tr class="text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                                    <th class="pb-4 pl-4 rtl:pl-0 rtl:pr-4 w-10 text-left rtl:text-right">
                                        <input type="checkbox" id="selectAll" class="w-4 h-4 rounded border-slate-300 text-teal-600 focus:ring-teal-500 cursor-pointer" onclick="toggleSelectAll()">
                                    </th>
                                    <th class="pb-4 pl-2 rtl:pl-0 rtl:pr-2">{{ __('strings.user_col') }}</th>
                                    <th class="pb-4">{{ __('strings.contact_info') }}</th>
                                    <th class="pb-4">{{ __('strings.location') }}</th>
                                    <th class="pb-4 text-center">{{ __('strings.risk_level') }}</th>
                                    <th class="pb-4 text-center">{{ __('strings.action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm font-medium text-slate-600">
                                @forelse($debtors as $debtor)
                                <tr class="group hover:bg-slate-50 transition border-b border-slate-50 last:border-none">
                                    <td class="py-4 pl-4 rtl:pl-0 rtl:pr-4"><input type="checkbox" class="row-checkbox w-4 h-4 rounded border-slate-300 text-teal-600 focus:ring-teal-500 cursor-pointer"></td>
                                    <td class="py-4 pl-2 rtl:pl-0 rtl:pr-2">
                                        <div class="flex items-center gap-3">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($debtor->name) }}&background=random&color=fff" class="w-10 h-10 rounded-xl bg-slate-100 border border-slate-200">
                                            <div>
                                                <a href="{{ route('creditor.debtors.show', $debtor->id) }}" class="text-slate-800 font-bold group-hover:text-teal-600 transition block">
    {{ $debtor->name }}
</a>
                                                <span class="text-xs text-slate-400">ID: {{ $debtor->id }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 font-mono text-xs">{{ $debtor->phone }}</td>
                                    <td class="py-4">{{ $debtor->address ?? __('strings.unknown') }}</td>
                                    <td class="py-4 text-center">
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase shadow-sm text-white {{ getStatusColorClass($debtor->risk_status) }}">
                                            {{ getStatusLabelText($debtor->risk_status) }}
                                        </span>
                                    </td>
                                    <td class="py-4 text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="https://wa.me/{{ $debtor->phone }}" target="_blank" class="p-2 text-slate-400 hover:text-green-600 hover:bg-green-50 rounded-full transition" title="{{ __('strings.whatsapp') }}">
                                                <i data-lucide="message-circle" class="w-4 h-4"></i>
                                            </a>
                                            <button onclick="openReminderModal('{{ $debtor->name }}', '{{ $debtor->id }}')" class="p-2 text-slate-400 hover:text-indigo-500 hover:bg-indigo-50 rounded-full transition" title="{{ __('strings.send_reminder_tooltip') }}">
                                                <i data-lucide="bell-ring" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-slate-400">
                                        <div class="flex flex-col items-center">
                                            <i data-lucide="search-x" class="w-10 h-10 mb-2 opacity-50"></i>
                                            <p>{{ __('strings.no_records_found') }}</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $debtors->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>

            {{-- الشريط الجانبي --}}
            <div class="lg:col-span-4 space-y-8">
                
                {{-- أزرار الوصول السريع --}}
                <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100">
                    <div class="flex items-center gap-2 mb-6 border-l-4 rtl:border-l-0 rtl:border-r-4 border-teal-500 pl-3 rtl:pl-0 rtl:pr-3"><h3 class="font-bold text-slate-800">{{ __('strings.quick_process') }}</h3></div>
                    <div class="space-y-4">
                        
                        {{-- زر إضافة دين --}}
                        <button onclick="toggleModal('addDebtModal')" class="w-full flex items-center p-4 bg-[#F8FAFC] hover:bg-teal-50 rounded-2xl transition group text-left rtl:text-right border border-transparent hover:border-teal-100">
                            <div class="w-10 h-10 mr-4 rtl:mr-0 rtl:ml-4 text-teal-500 font-bold flex items-center justify-center bg-white rounded-xl shadow-sm group-hover:bg-teal-500 group-hover:text-white transition"><i data-lucide="plus" class="w-5 h-5"></i></div>
                            <div>
                                <span class="block text-sm font-bold text-slate-800">{{ __('strings.add_debt') }}</span>
                                <span class="text-[10px] text-slate-400">{{ __('strings.record_new_liability') }}</span>
                            </div>
                        </button>
                        
                        {{-- زر إضافة مدين جديد --}}
                        <button onclick="toggleModal('addUserModal')" class="w-full flex items-center p-4 bg-[#F8FAFC] hover:bg-indigo-50 rounded-2xl transition group text-left rtl:text-right border border-transparent hover:border-indigo-100">
                            <div class="w-10 h-10 mr-4 rtl:mr-0 rtl:ml-4 text-indigo-500 font-bold flex items-center justify-center bg-white rounded-xl shadow-sm group-hover:bg-indigo-500 group-hover:text-white transition"><i data-lucide="user-plus" class="w-5 h-5"></i></div>
                            <div>
                                <span class="block text-sm font-bold text-slate-800">{{ __('strings.create_record') }}</span>
                                <span class="text-[10px] text-slate-400">{{ __('strings.new_debtor_profile') }}</span>
                            </div>
                        </button>

                         {{-- زر إضافة دفعة --}}
                         <button onclick="toggleModal('addPaymentModal')" class="w-full flex items-center p-4 bg-[#F8FAFC] hover:bg-yellow-50 rounded-2xl transition group text-left rtl:text-right border border-transparent hover:border-yellow-100">
                            <div class="w-10 h-10 mr-4 rtl:mr-0 rtl:ml-4 text-yellow-500 font-bold flex items-center justify-center bg-white rounded-xl shadow-sm group-hover:bg-yellow-500 group-hover:text-white transition"><i data-lucide="dollar-sign" class="w-5 h-5"></i></div>
                            <div>
                                <span class="block text-sm font-bold text-slate-800">{{ __('strings.add_payment') }}</span>
                                <span class="text-[10px] text-slate-400">{{ __('strings.record_installment') }}</span>
                            </div>
                        </button>
                    </div>
                </div>

                {{-- أفضل المسددين  --}}
                <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100">
                    <div class="flex items-center gap-2 mb-6 border-l-4 rtl:border-l-0 rtl:border-r-4 border-teal-500 pl-3 rtl:pl-0 rtl:pr-3"><h3 class="font-bold text-slate-800">{{ __('strings.top_payers') }}</h3></div>
                    <div class="space-y-5">
                        @forelse($topPayers as $payer)
                            <div class="flex gap-3 items-center p-3 hover:bg-slate-50 rounded-2xl transition cursor-pointer border border-transparent hover:border-slate-100">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($payer->debtor->name) }}&background=random&color=fff" class="w-12 h-12 rounded-xl bg-slate-100">
                                <div class="flex-1">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-sm font-bold text-slate-800">{{ $payer->debtor->name }}</span>
                                        <span class="text-[10px] text-teal-600 font-bold bg-teal-50 px-2 py-0.5 rounded-md">${{ number_format($payer->total_paid) }}</span>
                                    </div>
                                    <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="bg-teal-500 h-full rounded-full" style="width: 80%"></div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 text-center">{{ __('strings.no_records_found') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('creditor.modals.add_debtor')
    @include('creditor.modals.add_debt')
    @include('creditor.modals.add_payment')
    @include('creditor.modals.send_warning')

@endsection

@push('scripts')
<script src="{{ asset('js/creditorLog.js') }}"></script>
@endpush