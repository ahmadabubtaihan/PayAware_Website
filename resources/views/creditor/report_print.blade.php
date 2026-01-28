<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $reportTitle }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="{{ asset('css/creditorStyle.css') }}">
</head>
<body class="bg-slate-100 py-10 font-sans">
    <div class="max-w-3xl mx-auto bg-white p-10 shadow-lg rounded-xl print:p-0 print:shadow-none">
        <div class="flex justify-between items-center border-b pb-6 mb-6">
            <div>
                <h1 class="text-2xl font-bold">{{ $reportTitle }}</h1>
                <p class="text-slate-500 text-sm">{{ __('strings.generated_on') }}: {{ now()->format('Y-m-d H:i') }}</p>
            </div>
            <button onclick="window.print()" class="no-print bg-slate-800 text-white px-4 py-2 rounded-lg font-bold">{{ __('strings.print') }} 🖨️</button>
        </div>

        {{-- ملخص الأرقام --}}
        <div class="grid grid-cols-3 gap-4 mb-8 text-center">
            <div class="bg-slate-50 p-4 rounded border">
                <p class="text-xs text-slate-500 font-bold uppercase">{{ __('strings.total_debt_issued') }}</p>
                <p class="text-xl font-bold text-red-500">${{ number_format($totalDebts, 2) }}</p>
            </div>
            <div class="bg-slate-50 p-4 rounded border">
                <p class="text-xs text-slate-500 font-bold uppercase">{{ __('strings.collected') }}</p>
                <p class="text-xl font-bold text-teal-600">${{ number_format($totalCollected, 2) }}</p>
            </div>
            <div class="bg-slate-50 p-4 rounded border">
                <p class="text-xs text-slate-500 font-bold uppercase">{{ __('strings.net_change') }}</p>
                <p class="text-xl font-bold text-slate-800">${{ number_format($netChange, 2) }}</p>
            </div>
        </div>

        {{-- جدول العمليات --}}
        <table class="w-full text-left rtl:text-right text-sm">
            <thead>
                <tr class="bg-slate-100 border-b">
                    <th class="p-3">{{ __('strings.time') }}</th>
                    <th class="p-3">{{ __('strings.type') }}</th>
                    <th class="p-3">{{ __('strings.debtor') }}</th>
                    <th class="p-3 text-right rtl:text-left">{{ __('strings.amount') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $t)
                <tr class="border-b">
                    <td class="p-3">{{ $t->created_at->format('H:i') }}</td>
                    <td class="p-3 font-bold {{ $t->record_type == 'debt' ? 'text-red-500' : 'text-teal-600' }}">
                        {{ $t->record_type == 'debt' ? __('strings.new_debt') : __('strings.payment') }}
                    </td>
                    <td class="p-3">{{ ($t->record_type == 'debt' ? $t->debtor->name : $t->debt->debtor->name) ?? '-' }}</td>
                    <td class="p-3 text-right rtl:text-left font-bold">${{ number_format($t->amount, 2) }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="p-6 text-center text-slate-400">{{ __('strings.no_records_found') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>