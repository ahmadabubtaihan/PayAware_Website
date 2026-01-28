<?php

namespace App\Http\Controllers\Debtor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Debt;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class DebtorController extends Controller
{
    /**
     * عرض لوحة تحكم المدين (Dashboard)
     */
    public function dashboard()
    {
        $user = Auth::user();

        $debts = $user->debtsAsDebtor()
                      ->with('creditor')
                      ->latest()
                      ->get();

        $totalDebt = $debts->sum('amount');
        $remainingDebt = $debts->sum('remaining_amount');
        $totalPaid = $totalDebt - $remainingDebt;

        $recentPayments = $user->paymentsMade()
                               ->latest()
                               ->take(5)
                               ->get();

        $recentActivities = $debts->take(5);

        $creditorIds = $debts->pluck('creditor_id')->unique();
        $posts = Post::whereIn('user_id', $creditorIds)
                     ->with(['user', 'comments.user', 'likes'])
                     ->latest()
                     ->take(10)
                     ->get();

        return view('debtor.dashboard', compact(
            'user',
            'debts', 
            'totalDebt', 
            'remainingDebt', 
            'totalPaid',
            'recentPayments',
            'recentActivities',
            'posts'
        ));
    }

    /**
     * صفحة محفظة الديون (الإحصائيات والرسوم البيانية)
     */
    public function myDebts()
    {
        $user = Auth::user();

        // 1. جلب الديون
        $debts = $user->debtsAsDebtor()->with('creditor')->get();

        // 2. حساب المجاميع
        $totalDebt = $debts->sum('amount');
        $remainingDebt = $debts->sum('remaining_amount');
        $totalPaid = $totalDebt - $remainingDebt;

        // 3. تجهيز إحصائيات الشركات (للرسم البياني)
        $companyStats = $debts->groupBy('creditor_id')->map(function ($group) {
            $firstItem = $group->first();
            $companyName = $firstItem->creditor->company_name ?? $firstItem->creditor->name;
            
            $groupTotal = $group->sum('amount');
            $groupRemaining = $group->sum('remaining_amount');
            $groupPaid = $groupTotal - $groupRemaining;

            $status = 'unpaid';
            if ($groupRemaining == 0) {
                $status = 'paid';
            } elseif ($groupPaid > 0) {
                $status = 'partial';
            }

            return [
                'name' => $companyName,
                'total_debt' => $groupTotal,
                'total_paid' => $groupPaid,
                'status' => $status
            ];
        })->values();

        // 4. سجل العمليات التفصيلي (دمج الديون والمدفوعات)
        $debtTransactions = $user->debtsAsDebtor()->with('creditor')->get()->map(function ($debt) {
            $debt->type_label = 'debt';
            $debt->date = $debt->created_at;
            return $debt;
        });

        $paymentTransactions = $user->paymentsMade()->with('debt.creditor')->get()->map(function ($payment) {
            $payment->type_label = 'payment';
            $payment->date = $payment->created_at;
            return $payment;
        });

        $transactions = $debtTransactions->concat($paymentTransactions)->sortByDesc('date');

        return view('debtor.debts', compact(
            'totalDebt',
            'totalPaid',
            'remainingDebt',
            'companyStats',
            'transactions'
        ));
    }

    /**
     * عرض تفاصيل دين محدد
     */
    public function showDebt($id)
    {
        $debt = Auth::user()
                    ->debtsAsDebtor()
                    ->with(['creditor', 'payments'])
                    ->findOrFail($id);

        return view('debtor.debts.show', compact('debt')); 
    }

    /**
     * تبديل الإعجاب بالمنشور
     */
    public function toggleLike($postId)
    {
        $post = Post::findOrFail($postId);
        $userId = Auth::id();

        if ($post->likes()->where('user_id', $userId)->exists()) {
            $post->likes()->detach($userId);
            $post->decrement('likes_count');
        } else {
            $post->likes()->attach($userId);
            $post->increment('likes_count');
        }

        return back();
    }

    /**
     * إضافة تعليق
     */
    public function storeComment(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        Comment::create([
            'post_id' => $postId,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return back()->with('success', __('strings.comment_added_successfully'));
    }

    /**
     * تحميل شهادة براءة الذمة
     */
    public function downloadCertificate()
    {
        $user = Auth::user();
        $remainingDebt = $user->debtsAsDebtor()->sum('remaining_amount');
        $fileName = 'Clearance_Certificate_' . $user->id . '.html';

        return response()->streamDownload(function () use ($user, $remainingDebt) {
            echo view('debtor.certificate_template', compact('user', 'remainingDebt'))->render();
        }, $fileName);
    }

    /**
     * صفحة سجل المعاملات (History)
     */
    public function history()
    {
        $user = Auth::user();

        // 1. الديون
        $debts = $user->debtsAsDebtor()->with('creditor')->get()->map(function ($debt) {
            $debt->type_label = 'debt';
            $debt->type = 'New Debt';
            $debt->action_date = $debt->created_at;
            $debt->status = $debt->remaining_amount > 0 ? 'active' : 'paid';
            return $debt;
        });

        // 2. المدفوعات
        $payments = $user->paymentsMade()->with('debt.creditor')->get()->map(function ($payment) {
            $payment->type_label = 'payment';
            $payment->type = 'Payment';
            $payment->action_date = $payment->created_at;
            $payment->status = 'completed';
            return $payment;
        });

        // 3. الدمج والترتيب
        $merged = $debts->concat($payments)->sortByDesc('action_date');

        // 4. الإحصائيات
        $totalTransactionsCount = $merged->count();
        $totalPaidHistory = $payments->sum('amount');
        
        $lastPayment = $payments->sortByDesc('created_at')->first();
        $lastPaymentDate = $lastPayment ? $lastPayment->created_at->format('Y-m-d') : '-';

        // 5. Pagination يدوي
        $currentPage = Paginator::resolveCurrentPage();
        $perPage = 10;
        $currentPageItems = $merged->slice(($currentPage - 1) * $perPage, $perPage)->all();
        
        $transactions = new LengthAwarePaginator(
            $currentPageItems,
            $merged->count(),
            $perPage,
            $currentPage,
            ['path' => \Illuminate\Support\Facades\Request::url(), 'query' => \Illuminate\Support\Facades\Request::query()]
        );

        return view('debtor.history', compact(
            'transactions',
            'totalTransactionsCount',
            'totalPaidHistory',
            'lastPaymentDate'
        ));
    }

    /**
     * الملف الشخصي
     */
    public function profile()
    {
        $user = Auth::user();
        return view('debtor.profile', compact('user'));
    }

  
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->update(['avatar' => $path]);
        }

        return back()->with('success', __('strings.avatar_updated'));
    }

    /**
     * الإعدادات
     */
    public function settings()
    {
        return view('debtor.settings');
    }

    // ==========================================
    // ==========================================

    /**
     * تحديد إشعار واحد كمقروء
     */
    public function markNotificationAsRead($id)
    {
        $notification = Auth::user()->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();
            
            if (isset($notification->data['url'])) {
                return redirect($notification->data['url']);
            }
        }

        return back();
    }

    /**
     * تحديد الكل كمقروء
     */
    public function markAllNotificationsAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back();
    }

    public function updateProfile(Request $request)
{
    $user = Auth::user();
    $validated = $request->validate([
        'job_title' => 'nullable|string|max:100',
        'bio' => 'nullable|string|max:500',
        'work_place' => 'nullable|string|max:100',
        'study_place' => 'nullable|string|max:100',
        'address' => 'nullable|string|max:255',
    ]);

    $user->update($validated);
    return back()->with('success', __('strings.profile_updated'));
}
/**
     * تحديث بيانات الملف الشخصي
     */
    public function updateProfileSettings(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $user->update($validated);

        return back()->with('success', __('strings.profile_updated') ?? 'تم تحديث البيانات بنجاح');
    }

    /**
     * تحديث كلمة المرور
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->password)
        ]);

        return back()->with('success', __('strings.password_updated') ?? 'تم تغيير كلمة المرور بنجاح');
    }

    /**
     * تحديث تفضيلات الإشعارات
     */
    public function updateNotificationSettings(Request $request)
    {
        $user = Auth::user();
        
        $preferences = [
            'email' => $request->has('email_notifs'),
            'push' => $request->has('push_notifs'),
            'whatsapp' => $request->has('whatsapp_alerts'),
        ];

        $user->update(['notification_preferences' => $preferences]);

        return back()->with('success', __('strings.preferences_updated') ?? 'تم تحديث تفضيلات الإشعارات');
    }
}