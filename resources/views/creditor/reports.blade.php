@extends('layouts.creditorNItems')

@section('title', __('strings.financial_reports') . ' | PayAware')

@section('content')
<main class="pt-28 pb-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    
    {{-- Header & Filters --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-800">{{ __('strings.reports_page_title') }}</h1>
            <p class="text-slate-500 mt-1">{{ __('strings.reports_page_desc') }}</p>
        </div>
        
        {{-- الفلترة --}}
        <form action="{{ route('creditor.reports') }}" method="GET" class="flex items-center gap-2 bg-white p-1.5 rounded-xl border border-slate-200 shadow-sm">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 rtl:left-auto rtl:right-0 pl-3 rtl:pl-0 rtl:pr-3 flex items-center pointer-events-none">
                    <i data-lucide="calendar" class="w-4 h-4 text-slate-400"></i>
                </div>
                <input type="date" name="start_date" class="pl-10 rtl:pl-3 rtl:pr-10 pr-3 py-2 bg-transparent border-none text-sm font-bold text-slate-600 focus:ring-0" value="{{ $startDate }}">
            </div>
            <span class="text-slate-300 font-bold">-</span>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 rtl:left-auto rtl:right-0 pl-3 rtl:pl-0 rtl:pr-3 flex items-center pointer-events-none">
                    <i data-lucide="calendar" class="w-4 h-4 text-slate-400"></i>
                </div>
                <input type="date" name="end_date" class="pl-10 rtl:pl-3 rtl:pr-10 pr-3 py-2 bg-transparent border-none text-sm font-bold text-slate-600 focus:ring-0" value="{{ $endDate }}">
            </div>
            <button type="submit" class="bg-slate-900 text-white p-2 rounded-lg hover:bg-teal-600 transition shadow-md">
                <i data-lucide="filter" class="w-4 h-4"></i>
            </button>
        </form>
    </div>

    {{-- كرت الحالات --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        {{-- Card 1: Total Debt Issued --}}
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex flex-col justify-between h-40 relative overflow-hidden group">
            <div class="absolute right-0 rtl:right-auto rtl:left-0 top-0 w-32 h-32 bg-indigo-50 rounded-full -mr-10 rtl:-mr-0 rtl:-ml-10 -mt-10 transition group-hover:scale-110"></div>
            <div class="relative z-10">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">{{ __('strings.total_debt_issued') }}</p>
                <h3 class="text-3xl font-black text-slate-800 mt-2">${{ number_format($totalDebts, 2) }}</h3>
            </div>
            <div class="relative z-10 flex items-center gap-2 text-xs font-bold text-indigo-500">
                <span class="bg-indigo-50 px-2 py-1 rounded-full"><i data-lucide="trending-up" class="w-3 h-3 inline"></i></span>
                <span class="text-slate-400">{{ __('strings.period_summary') }}</span>
            </div>
        </div>

        {{-- التوتال المستجمع --}}
        <div class="bg-teal-500 p-6 rounded-[2rem] shadow-lg shadow-teal-200 flex flex-col justify-between h-40 relative overflow-hidden group">
            <div class="absolute right-0 rtl:right-auto rtl:left-0 top-0 w-32 h-32 bg-white/10 rounded-full -mr-10 rtl:-mr-0 rtl:-ml-10 -mt-10 transition group-hover:scale-110"></div>
            <div class="relative z-10 text-white">
                <p class="text-xs font-bold text-teal-100 uppercase tracking-wider">{{ __('strings.total_collected') }}</p>
                <h3 class="text-3xl font-black mt-2">${{ number_format($totalCollected, 2) }}</h3>
            </div>
            <div class="relative z-10 flex items-center gap-2 text-xs font-bold text-white">
                <span class="bg-white/20 px-2 py-1 rounded-full text-white"><i data-lucide="check-circle" class="w-3 h-3 inline"></i></span>
                <span class="text-teal-100">{{ __('strings.period_summary') }}</span>
            </div>
        </div>

        {{-- سيكشن 3 --}}
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex flex-col justify-between h-40 relative overflow-hidden group">
            <div class="absolute right-0 rtl:right-auto rtl:left-0 top-0 w-32 h-32 bg-red-50 rounded-full -mr-10 rtl:-mr-0 rtl:-ml-10 -mt-10 transition group-hover:scale-110"></div>
            <div class="relative z-10">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">{{ __('strings.outstanding_amount') }}</p>
                <h3 class="text-3xl font-black text-slate-800 mt-2">${{ number_format($residual, 2) }}</h3>
            </div>
            <div class="relative z-10 flex items-center gap-2 text-xs font-bold text-red-500">
                <span class="bg-red-50 px-2 py-1 rounded-full"><i data-lucide="alert-circle" class="w-3 h-3 inline"></i></span>
                <span class="text-slate-400">{{ __('strings.total_active_debt') }}</span>
            </div>
        </div>
    </div>

    {{-- للشارت --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        
        {{-- شارت العوائد --}}
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <i data-lucide="bar-chart-2" class="w-5 h-5 text-teal-500"></i> {{ __('strings.revenue_vs_debt') }}
                </h3>
            </div>
            <div class="h-64 w-full">
                <canvas id="reportsRevenueChart"></canvas>
            </div>
        </div>

        {{-- شارت طرق الدفع  --}}
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <i data-lucide="pie-chart" class="w-5 h-5 text-indigo-500"></i> {{ __('strings.transactions_by_method') }}
                </h3>
            </div>
            <div class="h-64 w-full flex items-center justify-center relative">
                <canvas id="methodsChart"></canvas>
                @if(count($methodValues) == 0)
                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none flex-col">
                        <span class="text-xs text-slate-400">{{ __('strings.no_data') }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- جدول التفاصيل  --}}
    <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
            <h3 class="font-bold text-slate-800 text-lg">{{ __('strings.detailed_transaction_report') }}</h3>
            <div class="flex gap-2">
                <button onclick="window.print()" class="px-4 py-2 bg-teal-50 text-teal-600 rounded-xl text-xs font-bold hover:bg-teal-100 border border-teal-100 transition">
                    <i data-lucide="printer" class="w-3 h-3 inline mr-1 rtl:mr-0 rtl:ml-1"></i> {{ __('strings.print') }}
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left rtl:text-right border-collapse">
                <thead>
                    <tr class="text-xs text-slate-400 border-b border-slate-100 uppercase tracking-wider">
                        <th class="py-4 font-bold pl-2 rtl:pl-0 rtl:pr-2">{{ __('strings.date') }}</th>
                        <th class="py-4 font-bold">{{ __('strings.debtor_name') }}</th>
                        <th class="py-4 font-bold">{{ __('strings.type') }}</th>
                        <th class="py-4 font-bold">{{ __('strings.method') }}</th>
                        <th class="py-4 font-bold text-right rtl:text-left pr-2 rtl:pr-0 rtl:pl-2">{{ __('strings.amount') }}</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($transactions as $item)
                        <tr class="border-b border-slate-50 hover:bg-slate-50 transition group">
                            <td class="py-4 pl-2 rtl:pl-0 rtl:pr-2 font-bold text-slate-600">
                                {{ $item->created_at->format('Y-m-d') }}
                                <span class="block text-[10px] text-slate-400 font-normal">{{ $item->created_at->format('h:i A') }}</span>
                            </td>
                            <td class="py-4 flex items-center gap-2">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($item->debtor->name ?? 'User') }}&background=random&color=fff&size=64" class="w-8 h-8 rounded-full bg-slate-100 border border-slate-200">
                                <span class="font-bold text-slate-800">{{ $item->debtor->name ?? __('strings.unknown') }}</span>
                            </td>
                            <td class="py-4">
                                @if($item->record_type == 'payment')
                                    <span class="bg-green-50 text-green-600 px-2 py-1 rounded-md text-xs font-bold border border-green-100">
                                        {{ __('strings.repayment_installment') }}
                                    </span>
                                @else
                                    <span class="bg-red-50 text-red-500 px-2 py-1 rounded-md text-xs font-bold border border-red-100">
                                        {{ __('strings.new_debt_product') }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 text-slate-500">
                                @if($item->record_type == 'payment')
                                    {{ __('strings.' . $item->method) }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="py-4 text-right rtl:text-left pr-2 rtl:pr-0 rtl:pl-2 font-black {{ $item->record_type == 'payment' ? 'text-teal-600' : 'text-slate-800' }}">
                                {{ $item->record_type == 'payment' ? '+' : '-' }}${{ number_format($item->amount, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400">
                                {{ __('strings.no_records_found_period') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script src="{{ asset('js/creditorLog.js') }}"></script>
@endpush