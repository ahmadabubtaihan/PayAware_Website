<?php

namespace App\Http\Controllers\Creditor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Debt;
use App\Models\Payment;

class DebtorsController extends Controller
{
    /**
     *  عرض قائمة جميع المدينين 
     */
    public function index(Request $request)
    {
        $creditorId = Auth::id();

        $totalReceivables = Debt::where('creditor_id', $creditorId)->sum('remaining_amount');
        
        $collectedThisMonth = Payment::where('creditor_id', $creditorId)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');

        $query = User::whereHas('debtsAsDebtor', function($q) use ($creditorId) {
            $q->where('creditor_id', $creditorId);
        })->with(['debtsAsDebtor' => function($q) use ($creditorId) {
            $q->where('creditor_id', $creditorId);
        }]);

        if ($request->filled('query')) {
            $term = $request->input('query');
            $query->where(function($q) use ($term) {
                $q->where('name', 'LIKE', "%{$term}%")
                  ->orWhere('email', 'LIKE', "%{$term}%")
                  ->orWhere('phone', 'LIKE', "%{$term}%") 
                  ->orWhere('id', $term);
            });
        }

        $debtors = $query->paginate(10);

        $highRiskCount = 0;

        $debtors->getCollection()->transform(function ($debtor) use (&$highRiskCount) {
            $totalDebt = $debtor->debtsAsDebtor->sum('remaining_amount');
            
            $hasOverdue = $debtor->debtsAsDebtor->where('status', 'overdue')->count() > 0;
            
            if ($hasOverdue) {
                $debtor->risk_status = 'high';
                $highRiskCount++;
            } elseif ($totalDebt > 5000) { 
                $debtor->risk_status = 'medium';
            } else {
                $debtor->risk_status = 'low';
            }

            return $debtor;
        });

        if ($request->filled('status')) {
            $status = $request->input('status');
            $filteredCollection = $debtors->getCollection()->filter(function ($debtor) use ($status) {
                return $debtor->risk_status === $status;
            });
            $debtors->setCollection($filteredCollection);
        }

        $topPayers = Payment::where('creditor_id', $creditorId)
            ->selectRaw('debtor_id, sum(amount) as total_paid')
            ->groupBy('debtor_id')
            ->orderByDesc('total_paid')
            ->take(3)
            ->with('debtor')
            ->get();

        return view('creditor.debtors', compact(
            'debtors', 
            'totalReceivables', 
            'collectedThisMonth', 
            'highRiskCount',
            'topPayers'
        ));
    }

    /**
     *  عرض تفاصيل مدين محدد (Details Page)
     */
    public function show($id)
    {
        $creditorId = Auth::id();
        
        $debtor = User::findOrFail($id);

        $totalDebt = Debt::where('creditor_id', $creditorId)
            ->where('debtor_id', $id)
            ->sum('amount');

        $totalPaid = Payment::where('creditor_id', $creditorId)
            ->where('debtor_id', $id)
            ->sum('amount');

        $remainingDebt = Debt::where('creditor_id', $creditorId)
            ->where('debtor_id', $id)
            ->sum('remaining_amount');

        $payments = Payment::where('creditor_id', $creditorId)
            ->where('debtor_id', $id)
            ->orderByDesc('created_at')
            ->get();

        $hasOverdue = Debt::where('creditor_id', $creditorId)
            ->where('debtor_id', $id)
            ->where('status', 'overdue')
            ->exists();
            
        $debtor->risk_status = $hasOverdue ? 'high' : ($remainingDebt > 5000 ? 'medium' : 'low');

        return view('creditor.debtor_details', compact(
            'debtor', 
            'totalDebt', 
            'totalPaid', 
            'remainingDebt', 
            'payments'
        ));
    }
}