@extends('layouts.debtor')

@section('title', __('strings.my_debts_title'))

@push('head-scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<main class="pt-28 pb-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">{{ __('strings.my_debts_portfolio') }}</h1>
            <p class="text-slate-500 mt-2">{{ __('strings.portfolio_desc') }}</p>
        </div>
        <button onclick="openCalculator()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-indigo-200 transition flex items-center gap-2">
            <i data-lucide="calculator" class="w-5 h-5"></i> {{ __('strings.installment_calc') }}
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center gap-4 group hover:-translate-y-1 transition">
            <div class="w-14 h-14 bg-indigo-50 text-indigo-500 rounded-2xl flex items-center justify-center shadow-inner">
                <i data-lucide="sigma" class="w-7 h-7"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">{{ __('strings.total_debt') }}</p>
                <h3 class="text-2xl font-extrabold text-slate-800">${{ number_format($totalDebt, 2) }}</h3>
            </div>
        </div>
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center gap-4 group hover:-translate-y-1 transition">
            <div class="w-14 h-14 bg-teal-50 text-teal-500 rounded-2xl flex items-center justify-center shadow-inner">
                <i data-lucide="check-circle-2" class="w-7 h-7"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">{{ __('strings.total_paid') }}</p>
                <h3 class="text-2xl font-extrabold text-slate-800">${{ number_format($totalPaid, 2) }}</h3>
            </div>
        </div>
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center gap-4 group hover:-translate-y-1 transition">
            <div class="w-14 h-14 bg-orange-50 text-orange-500 rounded-2xl flex items-center justify-center shadow-inner">
                <i data-lucide="pie-chart" class="w-7 h-7"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">{{ __('strings.remaining') }}</p>
                <h3 class="text-2xl font-extrabold text-slate-800">${{ number_format($remainingDebt, 2) }}</h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100">
            <div class="flex items-center gap-2 mb-6">
                <div class="w-1 h-6 bg-teal-500 rounded-full"></div>
                <h3 class="font-bold text-slate-800 text-lg">{{ __('strings.debts_by_company') }}</h3>
            </div>
            
            <div class="overflow-x-auto custom-scroll">
                <table class="w-full text-left rtl:text-right">
                    <thead>
                        <tr class="text-xs font-bold text-slate-400 uppercase border-b border-slate-100">
                            <th class="pb-3 pl-2 rtl:pr-2 rtl:pl-0">{{ __('strings.company') }}</th>
                            <th class="pb-3">{{ __('strings.total_debt') }}</th>
                            <th class="pb-3">{{ __('strings.repaid') }}</th>
                            <th class="pb-3 text-right rtl:text-left">{{ __('strings.status') }}</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($companyStats as $stat)
                        <tr class="border-b border-slate-50 hover:bg-slate-50 transition">
                            <td class="py-4 pl-2 rtl:pr-2 rtl:pl-0 font-bold text-slate-700 flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-xs uppercase">
                                    {{ substr($stat['name'], 0, 1) }}
                                </div>
                                {{ $stat['name'] }}
                            </td>
                            <td class="py-4 font-bold text-slate-800">${{ number_format($stat['total_debt']) }}</td>
                            <td class="py-4 text-teal-600 font-bold">${{ number_format($stat['total_paid']) }}</td>
                            <td class="py-4 text-right rtl:text-left">
                                @if($stat['status'] == 'paid')
                                    <span class="bg-green-100 text-green-600 text-[10px] font-bold px-2 py-1 rounded-full">{{ __('strings.status_paid') }}</span>
                                @elseif($stat['status'] == 'partial')
                                    <span class="bg-yellow-100 text-yellow-600 text-[10px] font-bold px-2 py-1 rounded-full">{{ __('strings.status_partial') }}</span>
                                @else
                                    <span class="bg-red-100 text-red-600 text-[10px] font-bold px-2 py-1 rounded-full">{{ __('strings.status_unpaid') }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-4 text-center text-slate-400 text-sm">{{ __('strings.no_debts') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- للشارت --}}
        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100 flex flex-col items-center justify-center">
            <h3 class="font-bold text-slate-800 mb-6 self-start">{{ __('strings.distribution') }}</h3>
            <div class="w-64 h-64 relative">
                @if($companyStats->count() > 0)
                    <canvas id="debtDistributionChart"></canvas>
                @else
                    <div class="flex items-center justify-center h-full text-slate-400 text-sm">
                        {{ __('strings.no_data_chart') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-2">
                <div class="w-1 h-6 bg-indigo-500 rounded-full"></div>
                <h3 class="font-bold text-slate-800 text-lg">{{ __('strings.detailed_transactions') }}</h3>
            </div>
            <button class="text-sm font-bold text-indigo-500 hover:underline">{{ __('strings.download_report') }}</button>
        </div>
        
        <div class="overflow-x-auto custom-scroll">
            <table class="w-full text-left rtl:text-right border-collapse">
                <thead>
                    <tr class="text-xs text-slate-400 uppercase border-b border-slate-100">
                        <th class="py-3 pl-2 rtl:pr-2 rtl:pl-0">{{ __('strings.company') }}</th>
                        <th class="py-3">{{ __('strings.type') }}</th>
                        <th class="py-3">{{ __('strings.amount') }}</th>
                        <th class="py-3">{{ __('strings.date') }}</th>
                        <th class="py-3 text-right rtl:text-left">{{ __('strings.details') }}</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-600">
                    @forelse($transactions as $trx)
                    <tr class="border-b border-slate-50 hover:bg-slate-50 transition">
                        <td class="py-4 pl-2 rtl:pr-2 rtl:pl-0 font-bold text-slate-800">
                            {{-- التحقق من العلاقة للحصول على اسم الشركة --}}
                            @if($trx->type_label == 'debt')
                                {{ $trx->creditor->company_name ?? $trx->creditor->name ?? 'Unknown' }}
                            @else
                                {{-- في حال الدفعة، نصل للشركة عبر الدين --}}
                                {{ $trx->debt->creditor->company_name ?? $trx->debt->creditor->name ?? 'Unknown' }}
                            @endif
                        </td>
                        <td class="py-4">
                            @if($trx->type_label == 'debt')
                                <span class="flex items-center gap-1 text-red-500 font-bold"><i data-lucide="arrow-down-circle" class="w-3 h-3"></i> {{ __('strings.debt_label') }}</span>
                            @else
                                <span class="flex items-center gap-1 text-teal-500 font-bold"><i data-lucide="arrow-up-circle" class="w-3 h-3"></i> {{ __('strings.payment_label') }}</span>
                            @endif
                        </td>
                        <td class="py-4 font-bold {{ $trx->type_label == 'payment' ? 'text-teal-600' : '' }}">${{ number_format($trx->amount, 2) }}</td>
                        <td class="py-4">{{ $trx->date->format('M d, Y') }}</td>
                        <td class="py-4 text-right rtl:text-left">
                            <span class="text-xs text-slate-400">
                                @if($trx->type_label == 'debt')
                                    {{ $trx->description ?? 'New Debt' }}
                                @else
                                    {{ __('strings.method_'.$trx->method) ?? $trx->method }}
                                @endif
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-6 text-center text-slate-400">{{ __('strings.no_transactions') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</main>

@include('debtor.partials.calculator_modal')

@endsection

@push('scripts')
<<script src="{{ asset('js/debtorLog.js') }}"></script>
@endpush