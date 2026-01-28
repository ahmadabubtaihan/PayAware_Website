<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company; 
use App\Models\Ticket;  
use App\Models\Debt;   
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * الصفحة الرئيسية للوحة تحكم المسؤول
     */
    public function dashboard()
    {
        $totalCompanies = Company::count();
        
        $activeDebtors = User::where('role', 'debtor')
                             // ->where('is_active', true)
                             ->count();

        // $totalRevenue = Debt::sum('amount'); 
        $totalRevenue = 50000; // قيمة افتراضية للتجربة

        $pendingTickets = Ticket::where('status', 'pending')->count();

        $recentTickets = Ticket::with('user')->latest()->take(5)->get();

        $newCompanies = Company::latest()->take(5)->get();

        $labels = [];
        $data = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $labels[] = $date->format('M');
            
            $count = User::whereYear('created_at', $date->year)
                         ->whereMonth('created_at', $date->month)
                         ->count();
            $data[] = $count;
        }

        return view('admin.dashboard', compact(
            'totalCompanies', 
            'activeDebtors', 
            'totalRevenue', 
            'pendingTickets',
            'recentTickets',
            'newCompanies',
            'labels',
            'data'
        ));
    }

    /**
     * صفحة إدارة الشركات
     */
    public function companies()
    {
        $companies = Company::latest()->paginate(10);
        return view('admin.companies', compact('companies'));
    }

    /**
     * صفحة سجلات النظام
     */
    public function logs()
    {
        return view('admin.logs');
    }

    /**
     * صفحة النسخ الاحتياطي
     */
    public function backups()
    {
        return view('admin.backups');
    }

    /**
     * صفحة الصلاحيات والأدوار
     */

    public function roles()
    {
        $roles = \App\Models\Role::with('permissions')->get();

        $permissionsGroups = \App\Models\Permission::all()->groupBy('group_name');

        return view('admin.roles', compact('roles', 'permissionsGroups'));
    }

    /**
     * حفظ تحديثات الصلاحيات
     */
    public function updatePermissions(Request $request)
    {
        $matrix = $request->input('matrix', []);

        $roles = \App\Models\Role::all();

        foreach ($roles as $role) {
            if ($role->slug === 'admin') {
                continue; 
            }

            if (isset($matrix[$role->id])) {
                $permissionIds = array_keys($matrix[$role->id]);
                
                $role->permissions()->sync($permissionIds);
            } else {
                $role->permissions()->detach();
            }
        }

        return back()->with('success', __('strings.permissions_updated') ?? 'تم تحديث مصفوفة الصلاحيات بنجاح');
    }

    /**
     * إنشاء دور جديد
     */
    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'slug' => 'required|string|unique:roles,slug',
        ]);

        \App\Models\Role::create([
            'name' => $request->name,
            'slug' => strtolower(str_replace(' ', '_', $request->slug)),
            'description' => $request->description,
        ]);

        return back()->with('success', 'تم إنشاء الدور الجديد بنجاح');
    }


    /**
     * حفظ شركة جديدة
     */
    public function storeCompany(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:companies,email',
            'location' => 'nullable|string|max:255',
            'plan' => 'required|in:basic,pro,enterprise',
            'status' => 'required|in:active,pending,suspended',
        ]);

        Company::create($validated);

        return back()->with('success', __('strings.company_added_success') ?? 'تم إضافة الشركة بنجاح');
    }

    /**
     * تحديث حالة الشركة (تفعيل/إيقاف)
     */
    public function updateCompanyStatus(Request $request, $id)
    {
        $company = Company::findOrFail($id);
        $company->update(['status' => $request->status]);

        return back()->with('success', __('strings.status_updated') ?? 'تم تحديث الحالة بنجاح');
    }

    /**
     * حذف شركة
     */
    public function deleteCompany($id)
    {
        Company::findOrFail($id)->delete();
        return back()->with('success', __('strings.company_deleted') ?? 'تم حذف الشركة');
    }
}