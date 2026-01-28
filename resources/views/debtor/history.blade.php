@extends('layouts.debtor')

@section('title', __('strings.transaction_history'))

@section('content')
<main class="pt-28 pb-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800">{{ __('strings.transaction_history') }}</h1>
        <p class="text-slate-500 mt-2">{{ __('strings.track_activities') }}</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-5 rounded-[1.5rem] shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="p-3 bg-teal-50 text-teal-600 rounded-xl"><i data-lucide="history" class="w-6 h-6"></i></div>
            <div>
                <p class="text-xs text-slate-400 font-bold uppercase">{{ __('strings.transactions_count') }}</p>
                <h3 class="text-xl font-extrabold text-slate-800">{{ $totalTransactionsCount }}</h3>
            </div>
        </div>
        <div class="bg-white p-5 rounded-[1.5rem] shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl"><i data-lucide="arrow-up-right" class="w-6 h-6"></i></div>
            <div>
                <p class="text-xs text-slate-400 font-bold uppercase">{{ __('strings.total_paid') }}</p>
                <h3 class="text-xl font-extrabold text-slate-800">${{ number_format($totalPaidHistory, 2) }}</h3>
            </div>
        </div>
        <div class="bg-white p-5 rounded-[1.5rem] shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="p-3 bg-orange-50 text-orange-600 rounded-xl"><i data-lucide="calendar-check" class="w-6 h-6"></i></div>
            <div>
                <p class="text-xs text-slate-400 font-bold uppercase">{{ __('strings.last_payment') }}</p>
                <h3 class="text-xl font-extrabold text-slate-800">{{ $lastPaymentDate }}</h3>
            </div>
        </div>
        <div class="bg-gradient-to-r from-slate-800 to-slate-900 p-5 rounded-[1.5rem] shadow-lg text-white flex items-center justify-between cursor-pointer hover:shadow-xl transition">
            <div>
                <p class="text-xs text-slate-400 font-bold uppercase mb-1">{{ __('strings.download') }}</p>
                <h3 class="text-lg font-bold">{{ __('strings.full_statement') }}</h3>
            </div>
            <i data-lucide="download-cloud" class="w-6 h-6 text-teal-400"></i>
        </div>
    </div>

    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm mb-6 flex flex-col md:flex-row gap-4 justify-between items-center">
        <div class="relative w-full md:w-96">
            <input type="text" placeholder="{{ __('strings.search_transactions') }}" class="w-full pl-10 pr-4 rtl:pr-10 rtl:pl-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-500/20 transition">
            <i data-lucide="search" class="absolute left-3 rtl:right-3 rtl:left-auto top-2.5 w-4 h-4 text-slate-400"></i>
        </div>
        <div class="flex gap-3 w-full md:w-auto overflow-x-auto pb-2 md:pb-0">
            <select class="bg-slate-50 border border-slate-200 text-slate-600 text-xs font-bold rounded-xl px-4 py-2.5 focus:outline-none cursor-pointer hover:bg-slate-100">
                <option>{{ __('strings.filter_all_time') }}</option>
                <option>{{ __('strings.filter_this_month') }}</option>
            </select>
            <select class="bg-slate-50 border border-slate-200 text-slate-600 text-xs font-bold rounded-xl px-4 py-2.5 focus:outline-none cursor-pointer hover:bg-slate-100">
                <option>{{ __('strings.filter_all_types') }}</option>
                <option>{{ __('strings.filter_payments') }}</option>
                <option>{{ __('strings.filter_new_debts') }}</option>
            </select>
        </div>
    </div>

    {{-- جدول التحويلات --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto custom-scroll">
            <table class="w-full text-left rtl:text-right border-collapse">
                <thead class="bg-slate-50/50">
                    <tr class="text-xs text-slate-400 uppercase border-b border-slate-100">
                        <th class="py-4 pl-6 rtl:pr-6 rtl:pl-0 font-bold">{{ __('strings.th_trx_id') }}</th>
                        <th class="py-4 font-bold">{{ __('strings.company') }}</th>
                        <th class="py-4 font-bold">{{ __('strings.th_date_time') }}</th>
                        <th class="py-4 font-bold">{{ __('strings.type') }}</th>
                        <th class="py-4 font-bold">{{ __('strings.amount') }}</th>
                        <th class="py-4 font-bold">{{ __('strings.th_method') }}</th>
                        <th class="py-4 pr-6 rtl:pl-6 rtl:pr-0 text-right rtl:text-left font-bold">{{ __('strings.status') }}</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-600">
                    @forelse($transactions as $trx)
                        <tr class="border-b border-slate-50 hover:bg-slate-50/80 transition group">
                            <td class="py-4 pl-6 rtl:pr-6 rtl:pl-0 font-mono text-slate-400 text-xs">
                                #{{ $trx->transaction_id ?? 'TRX-'.$trx->id }}
                            </td>


                            <td class="py-4 flex items-center gap-3">
                                @php
                                    // تحديد الشركة بناءً على نوع العملية
                                    $companyName = 'Unknown';
                                    if ($trx->type_label == 'debt') {
                                        $companyName = $trx->creditor->company_name ?? $trx->creditor->name;
                                    } elseif ($trx->type_label == 'payment' && $trx->debt) {
                                        $companyName = $trx->debt->creditor->company_name ?? $trx->debt->creditor->name;
                                    }
                                @endphp
                                <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-xs uppercase">
                                    {{ substr($companyName, 0, 1) }}
                                </div>
                                <span class="font-bold text-slate-800">{{ $companyName }}</span>
                            </td>

                            <td class="py-4">
                                {{ $trx->action_date->format('M d, Y') }} 
                                <span class="text-slate-400 text-xs ml-1 rtl:mr-1 rtl:ml-0">{{ $trx->action_date->format('h:i A') }}</span>
                            </td>

                            <td class="py-4">
                                @if($trx->type_label == 'payment')
                                    <span class="flex items-center gap-1.5 text-teal-600 font-bold">
                                        <div class="w-1.5 h-1.5 rounded-full bg-teal-500"></div> {{ __('strings.payment_label') }}
                                    </span>
                                @else
                                    <span class="flex items-center gap-1.5 text-orange-600 font-bold">
                                        <div class="w-1.5 h-1.5 rounded-full bg-orange-500"></div> {{ __('strings.new_debt_label') }}
                                    </span>
                                @endif
                            </td>

                            <td class="py-4 font-bold text-slate-800">${{ number_format($trx->amount, 2) }}</td>

                            <td class="py-4 text-xs">
                                @if($trx->type_label == 'payment')
                                    {{ $trx->method }}
                                @else
                                    {{ $trx->type }}
                                @endif
                            </td>

                            {{-- الحالة --}}
                            <td class="py-4 pr-6 rtl:pl-6 rtl:pr-0 text-right rtl:text-left">
                                @if($trx->status == 'completed' || $trx->status == 'paid')
                                    <span class="bg-green-50 text-green-600 py-1 px-3 rounded-full text-xs font-bold border border-green-100">{{ __('strings.status_completed') }}</span>
                                @elseif($trx->status == 'pending')
                                    <span class="bg-yellow-50 text-yellow-600 py-1 px-3 rounded-full text-xs font-bold border border-yellow-100">{{ __('strings.status_pending') }}</span>
                                @elseif($trx->status == 'active')
                                    <span class="bg-slate-100 text-slate-500 py-1 px-3 rounded-full text-xs font-bold border border-slate-200">{{ __('strings.status_recorded') }}</span>
                                @else
                                    <span class="bg-red-50 text-red-600 py-1 px-3 rounded-full text-xs font-bold border border-red-100">{{ $trx->status }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400">{{ __('strings.no_transactions') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-slate-100 flex items-center justify-between">
            <p class="text-xs text-slate-400">
                {{ __('strings.showing_results', [
                    'start' => $transactions->firstItem() ?? 0, 
                    'end' => $transactions->lastItem() ?? 0, 
                    'total' => $transactions->total()
                ]) }}
            </p>
            
            {{-- عرض روابط الصفحات بشكل بسيط --}}
            @if($transactions->hasPages())
                <div class="flex gap-2">
                    {{-- زر السابق --}}
                    @if($transactions->onFirstPage())
                        <button disabled class="p-2 border border-slate-200 rounded-lg text-slate-300 cursor-not-allowed">
                            <i data-lucide="chevron-left" class="w-4 h-4 rtl:rotate-180"></i>
                        </button>
                    @else
                        <a href="{{ $transactions->previousPageUrl() }}" class="p-2 border border-slate-200 rounded-lg text-slate-500 hover:bg-slate-50">
                            <i data-lucide="chevron-left" class="w-4 h-4 rtl:rotate-180"></i>
                        </a>
                    @endif

                    {{-- زر التالي --}}
                    @if($transactions->hasMorePages())
                        <a href="{{ $transactions->nextPageUrl() }}" class="p-2 border border-slate-200 rounded-lg text-slate-500 hover:bg-slate-50">
                            <i data-lucide="chevron-right" class="w-4 h-4 rtl:rotate-180"></i>
                        </a>
                    @else
                        <button disabled class="p-2 border border-slate-200 rounded-lg text-slate-300 cursor-not-allowed">
                            <i data-lucide="chevron-right" class="w-4 h-4 rtl:rotate-180"></i>
                        </button>
                    @endif
                </div>
            @endif
        </div>
    </div>

</main>
@endsection