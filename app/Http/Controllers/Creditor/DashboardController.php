<?php

namespace App\Http\Controllers\Creditor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification; 
use App\Models\User;
use App\Models\Debt;
use App\Models\Payment;
use App\Models\Warning;
use App\Notifications\CreditorNotification; 

class DashboardController extends Controller
{
    /**
     * 1. عرض الصفحة الرئيسية للداشبورد
     */
    public function index()
    {
        $user = Auth::user();
        $creditorId = $user->id; 

        $totalDebtIssued = Debt::where('creditor_id', $creditorId)->sum('amount');
        $totalRepayment = Payment::where('creditor_id', $creditorId)->sum('amount');
        $residualOutstanding = Debt::where('creditor_id', $creditorId)->sum('remaining_amount');

        $activeAccountsCount = Debt::where('creditor_id', $creditorId)
            ->where('remaining_amount', '>', 0)
            ->distinct('debtor_id') 
            ->count('debtor_id');

        $activeWarnings = Warning::where('creditor_id', $creditorId)
            ->where('status', 'sent')
            ->count();

        $recentDebts = Debt::where('creditor_id', $creditorId)
            ->with('debtor')->latest()->take(5)->get()
            ->map(function ($debt) { $debt->record_type = 'debt'; return $debt; });

        $recentPayments = Payment::where('creditor_id', $creditorId)
            ->with(['debtor', 'debt'])->latest()->take(5)->get()
            ->map(function ($payment) { $payment->record_type = 'payment'; return $payment; });

        $recentRecords = $recentDebts->merge($recentPayments)->sortByDesc('created_at')->take(5);

        $companyPosts = collect();
        if ($user->company) {
            $companyPosts = $user->company->posts()->latest()->take(3)->withCount(['likes', 'comments'])->get();
        } else {
            $companyPosts = $user->posts()->latest()->take(3)->withCount(['likes', 'comments'])->get();
        }

        $chartLabels = [];
        $chartDebts = [];
        $chartRepayments = [];

        for ($i = 3; $i >= 0; $i--) {
            $startOfWeek = now()->subWeeks($i)->startOfWeek();
            $endOfWeek = now()->subWeeks($i)->endOfWeek();

            $chartLabels[] = $startOfWeek->format('d M');

            $chartDebts[] = Debt::where('creditor_id', $creditorId)
                ->whereBetween('created_at', [$startOfWeek, $endOfWeek])->sum('amount');

            $chartRepayments[] = Payment::where('creditor_id', $creditorId)
                ->whereBetween('created_at', [$startOfWeek, $endOfWeek])->sum('amount');
        }

        $topPayers = Payment::where('creditor_id', $creditorId)
            ->selectRaw('debtor_id, sum(amount) as total_paid')
            ->groupBy('debtor_id')
            ->orderByDesc('total_paid')
            ->take(5)
            ->with('debtor')
            ->get()
            ->map(function ($payer) use ($creditorId) {
                $totalDebt = Debt::where('creditor_id', $creditorId)
                    ->where('debtor_id', $payer->debtor_id)
                    ->sum('amount');

                if ($totalDebt > 0) {
                    $percentage = ($payer->total_paid / $totalDebt) * 100;
                    $payer->rating = min(100, round($percentage));
                } else {
                    $payer->rating = 0;
                }
                return $payer;
            });

        return view('creditor.dashboard', compact(
            'totalDebtIssued', 'totalRepayment', 'residualOutstanding',
            'activeAccountsCount', 'activeWarnings', 'recentRecords',
            'companyPosts', 'user', 'chartLabels', 'chartDebts', 
            'chartRepayments', 'topPayers'
        ));
    }

    public function history()
    {
        $user = Auth::user();
        $creditorId = $user->id;

        $debts = Debt::where('creditor_id', $creditorId)->with('debtor')->get()
            ->map(function ($item) { $item->record_type = 'debt'; return $item; });

        $payments = Payment::where('creditor_id', $creditorId)->with(['debtor', 'debt'])->get()
            ->map(function ($item) { $item->record_type = 'payment'; return $item; });

        $allRecords = $debts->merge($payments)->sortByDesc('created_at');

        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $allRecords->slice(($currentPage - 1) * $perPage, $perPage)->all();
        
        $records = new LengthAwarePaginator($currentItems, count($allRecords), $perPage);
        $records->setPath(request()->url());

        return view('creditor.history', compact('records'));
    }

    /**
     *  البحث
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        if (!$query) return redirect()->route('creditor.dashboard');

        $debtors = User::where('id', '!=', Auth::id())
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('email', 'LIKE', "%{$query}%")
                  ->orWhere('phone', 'LIKE', "%{$query}%")
                  ->orWhere('id', $query);
            })->get();

        return view('creditor.search_results', compact('debtors', 'query'));
    }

    /**
     * التقارير المختصرة (طباعة)
     */
    public function report($type = 'monthly')
    {
        $user = Auth::user();
        $creditorId = $user->id;
        $startDate = null; $endDate = null; $reportTitle = "";

        if (!in_array($type, ['daily', 'monthly'])) {
            $type = 'monthly';
        }

        if ($type == 'daily') {
            $startDate = now()->startOfDay();
            $endDate = now()->endOfDay();
            $reportTitle = __('strings.daily_report') . ' - ' . now()->format('Y-m-d');
        } else {
            $startDate = now()->startOfMonth();
            $endDate = now()->endOfMonth();
            $reportTitle = __('strings.monthly_report') . ' - ' . now()->format('F Y');
        }

        $debts = Debt::where('creditor_id', $creditorId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with('debtor')->get()->map(function ($item) { $item->record_type = 'debt'; return $item; });

        $payments = Payment::where('creditor_id', $creditorId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with(['debtor', 'debt'])->get()->map(function ($item) { $item->record_type = 'payment'; return $item; });

        $transactions = $debts->merge($payments)->sortByDesc('created_at');
        $totalDebts = $debts->sum('amount');
        $totalCollected = $payments->sum('amount');
        $netChange = $totalCollected - $totalDebts;

        return view('creditor.report_print', compact('transactions', 'totalDebts', 'totalCollected', 'netChange', 'reportTitle', 'type', 'user'));
    }

    /**
     * حفظ دين جديد + إشعار
     */
    public function storeDebt(Request $request)
    {
        $request->validate([
            'debtor_input' => 'required', 
            'amount' => 'required|numeric|min:1',
            'due_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $debtor = \App\Models\User::where('account_id', $request->debtor_input)
                    ->orWhere('id', $request->debtor_input)
                    ->first();

        if (!$debtor) {
            return back()->withErrors(['debtor_input' => __('strings.user_not_found') ?? 'المستخدم غير موجود، تأكد من رقم الحساب']);
        }

        if ($debtor->id == auth()->id()) {
            return back()->withErrors(['debtor_input' => 'لا يمكنك إضافة دين لنفسك']);
        }

        //  إنشاء الدين
        \App\Models\Debt::create([
            'creditor_id' => auth()->id(),
            'debtor_id' => $debtor->id, 
            'amount' => $request->amount,
            'remaining_amount' => $request->amount,
            'due_date' => $request->due_date,
            'description' => $request->description,
            'status' => 'active',
        ]);


        return back()->with('success', __('strings.debt_added') ?? 'تم إضافة الدين بنجاح');
    }

    /**
     *  تسجيل دفعة سداد + خوارزمية الخصم + إشعار
     */
public function storePayment(Request $request)
    {
        $request->validate([
            'debtor_input' => 'required', 
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $debtor = \App\Models\User::where('account_id', $request->debtor_input)
                    ->orWhere('id', $request->debtor_input)
                    ->first();

        if (!$debtor) {
            return back()->withErrors(['debtor_input' => __('strings.user_not_found') ?? 'المستخدم غير موجود']);
        }

        $creditorId = Auth::id();
        $amountToPay = $request->amount;
        $originalAmount = $amountToPay;

        $debts = \App\Models\Debt::where('creditor_id', $creditorId)
            ->where('debtor_id', $debtor->id) 
            ->where('remaining_amount', '>', 0)
            ->orderBy('created_at', 'asc')
            ->get();

        if ($debts->isEmpty()) {
            return redirect()->back()->with('error', __('strings.no_active_debts_for_user'));
        }

        $lastAffectedDebtId = null;

        foreach ($debts as $debt) {
            if ($amountToPay <= 0) break;
            $lastAffectedDebtId = $debt->id;

            if ($amountToPay >= $debt->remaining_amount) {
                $paid = $debt->remaining_amount;
                $amountToPay -= $paid;
                $debt->remaining_amount = 0;
                $debt->status = 'paid';
            } else {
                $paid = $amountToPay;
                $debt->remaining_amount -= $paid;
                $amountToPay = 0;
            }
            $debt->save();
        }

        //  إنشاء سجل الدفعة
        \App\Models\Payment::create([
            'transaction_id' => 'PAY-' . strtoupper(\Illuminate\Support\Str::random(10)),
            'creditor_id' => $creditorId,
            'debtor_id' => $debtor->id, 
            'debt_id' => $lastAffectedDebtId, 
            'amount' => $originalAmount,
            'payment_method' => $request->payment_method, 
            'notes' => $request->notes ?? 'Payment received via Dashboard',
        ]);

        //  إرسال الإشعار للدائن 
        $user = Auth::user();
         $user->notify(new \App\Notifications\CreditorNotification([
             'title' => 'Payment Recorded',
             'message' => 'Recorded $' . number_format($originalAmount) . ' from ' . $debtor->name,
             'icon' => 'check-circle',
             'color' => 'text-teal-600',
             'url' => route('creditor.debtors.show', $debtor->id)
         ]));

        return redirect()->back()->with('success', __('strings.payment_recorded_successfully') ?? 'تم تسجيل الدفعة بنجاح');
    }
    /**
     * إنشاء سجل مدين جديد
     */
    public function storeDebtor(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|string|min:6',
            'address' => 'nullable|string|max:255',
        ]);

        $debtor = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'debtor',
            'address' => $request->address,
        ]);

        return redirect()->back()->with('success', __('strings.debtor_created_successfully') . ' (ID: ' . $debtor->id . ')');
    }

    /**
     * إرسال تنبيه
     */
public function storeWarning(Request $request)
    {
        $request->validate([
            'debtor_input' => 'required', 
            'message' => 'required|string|max:500',
        ]);

        $debtor = \App\Models\User::where('account_id', $request->debtor_input)
                    ->orWhere('id', $request->debtor_input)
                    ->first();

        if (!$debtor) {
            return back()->withErrors(['debtor_input' => __('strings.user_not_found') ?? 'المستخدم غير موجود']);
        }

        if ($debtor->id == Auth::id()) {
            return redirect()->back()->with('error', __('strings.cannot_add_debt_to_self'));
        }

        \App\Models\Warning::create([
            'creditor_id' => Auth::id(),
            'debtor_id' => $debtor->id, 
            'type' => 'late_payment',
            'message' => $request->message,
            'status' => 'sent',
            'sent_at' => now(),
        ]);

        Auth::user()->notify(new \App\Notifications\CreditorNotification([
            'title' => 'Warning Sent',
            'message' => 'Warning sent to ' . $debtor->name,
            'icon' => 'bell',
            'color' => 'text-orange-500',
            'url' => route('creditor.debtors.show', $debtor->id)
        ]));


        return redirect()->back()->with('success', __('strings.warning_sent_successfully'));
    }
    /**
     * تمييز الإشعارات كمقروءة
     */
    public function markNotificationsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }
}