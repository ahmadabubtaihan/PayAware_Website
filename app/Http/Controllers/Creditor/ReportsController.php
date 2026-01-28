<?php

namespace App\Http\Controllers\Creditor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Debt;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        $creditorId = Auth::id();
        
        //  الفلاتر
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString()); // افتراضياً لليوم
        
        //  جلب الديون
        $debts = Debt::where('creditor_id', $creditorId)
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->with('debtor')
            ->get()
            ->map(function ($item) { $item->record_type = 'debt'; return $item; });

        // جلب المدفوعات
        $payments = Payment::where('creditor_id', $creditorId)
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->with('debtor')
            ->get()
            ->map(function ($item) { $item->record_type = 'payment'; return $item; });

        // دمج العمليات للجدول
        $transactions = $debts->merge($payments)->sortByDesc('created_at');

        // الإجماليات (Cards)
        $totalDebts = $debts->sum('amount');
        $totalCollected = $payments->sum('amount');
        $residual = Debt::where('creditor_id', $creditorId)->sum('remaining_amount'); // المتبقي الكلي (وليس للفترة فقط)

        // ==========================================
        // ==========================================

        $chartData = $transactions->groupBy(function($item) {
            return $item->created_at->format('Y-m-d');
        })->map(function($dayItems) {
            return [
                'debt' => $dayItems->where('record_type', 'debt')->sum('amount'),
                'payment' => $dayItems->where('record_type', 'payment')->sum('amount'),
            ];
        })->sortKeys(); 

        $chartLabels = $chartData->keys()->values(); 
        $chartDebtValues = $chartData->pluck('debt')->values();
        $chartPaymentValues = $chartData->pluck('payment')->values();

        $methodsData = $payments->groupBy('method')->map->count();
        $methodLabels = $methodsData->keys()->map(function($m) { return __('strings.'.$m); }); 
        $methodValues = $methodsData->values();

        return view('creditor.reports', compact(
            'transactions', 
            'totalDebts', 
            'totalCollected', 
            'residual',
            'startDate',
            'endDate',
            'chartLabels',
            'chartDebtValues',
            'chartPaymentValues',
            'methodLabels',
            'methodValues'
        ));
    }
}