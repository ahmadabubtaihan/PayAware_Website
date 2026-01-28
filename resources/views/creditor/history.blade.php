@extends('layouts.creditorNItems')

@section('title', __('strings.history') . ' | PayAware')

@section('content')
<main class="pt-28 pb-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    
    <div class="flex items-center justify-between mb-8">
        <div>
            <a href="{{ route('creditor.dashboard') }}" class="text-slate-500 hover:text-slate-700 flex items-center gap-2 mb-2 transition text-sm">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> {{ __('strings.back_to_dashboard') }}
            </a>
            <h1 class="text-2xl font-extrabold text-slate-800">{{ __('strings.transaction_history') }}</h1>
        </div>
        <button class="bg-white border border-slate-200 text-slate-600 px-4 py-2 rounded-xl text-sm font-bold flex items-center gap-2 hover:bg-slate-50">
            <i data-lucide="filter" class="w-4 h-4"></i> {{ __('strings.filter') }}
        </button>
    </div>

    {{-- جدول التسجيلات --}}
    <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100">
        <div class="overflow-x-auto">
            <table class="w-full text-left rtl:text-right border-collapse">
                <thead>
                    <tr class="text-xs text-slate-400 border-b border-slate-100">
                        <th class="py-3 font-bold uppercase">{{ __('strings.debtor') }}</th>
                        <th class="py-3 font-bold uppercase">{{ __('strings.type') }}</th>
                        <th class="py-3 font-bold uppercase">{{ __('strings.date') }}</th>
                        <th class="py-3 font-bold uppercase text-right rtl:text-left">{{ __('strings.amount') }}</th>
                        <th class="py-3 font-bold uppercase text-center">{{ __('strings.action') }}</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($records as $record)
                        @php
                            $debtor = ($record->record_type == 'debt') ? $record->debtor : ($record->debt->debtor ?? null);
                            $debtorName = $debtor ? $debtor->name : __('strings.unknown');
                        @endphp
                        <tr class="group hover:bg-slate-50 transition border-b border-slate-50 last:border-0">
                            <td class="py-4 flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($debtorName) }}&background=random&color=fff" class="w-8 h-8 rounded-full bg-slate-100">
                                <span class="font-bold text-slate-700">{{ $debtorName }}</span>
                            </td>
                            <td class="py-4">
                                @if($record->record_type == 'debt')
                                    <span class="px-2 py-1 rounded-lg bg-red-50 text-red-500 text-xs font-bold">{{ __('strings.new_debt') }}</span>
                                @else
                                    <span class="px-2 py-1 rounded-lg bg-teal-50 text-teal-600 text-xs font-bold">{{ __('strings.payment') }}</span>
                                @endif
                            </td>
                            <td class="py-4 text-slate-500">{{ $record->created_at->format('M d, Y - h:i A') }}</td>
                            <td class="py-4 text-right rtl:text-left font-bold {{ $record->record_type == 'payment' ? 'text-teal-600' : 'text-red-500' }}">
                                {{ $record->record_type == 'payment' ? '+' : '-' }}${{ number_format($record->amount, 2) }}
                            </td>
                            <td class="py-4 text-center">
                                <button onclick="showDetails('{{ $record->record_type }}', {{ $record }})" class="text-slate-400 hover:text-indigo-600 transition">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400">{{ __('strings.no_records_found') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{---------}}
        <div class="mt-6">
            {{ $records->links('pagination::tailwind') }}
        </div>
    </div>
</main>

{{-------------------------------}}
<div id="detailsModal" class="fixed inset-0 z-[100] hidden" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" onclick="closeDetails()"></div>
    <div class="fixed inset-0 z-10 overflow-y-auto flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6 relative">
            <button onclick="closeDetails()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600"><i data-lucide="x" class="w-5 h-5"></i></button>
            <h3 class="text-lg font-bold text-slate-800 mb-4">{{ __('strings.transaction_details') }}</h3>
            <div id="modalContent" class="space-y-3 text-sm text-slate-600">
                {{-- Content filled via JS --}}
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/creditorLog.js') }}"></script>
@endsection