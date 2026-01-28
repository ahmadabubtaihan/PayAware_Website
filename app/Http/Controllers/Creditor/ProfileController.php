<?php

namespace App\Http\Controllers\Creditor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Company;

class ProfileController extends Controller
{
    /**
     * عرض صفحة البروفايل (سواء لشركة أو لمستخدم فردي)
     */
    public function show()
    {
        $user = Auth::user();
        
        $company = $user->company()
            ->with(['posts' => function ($query) {
                $query->latest()->withCount(['likes', 'comments']); 
            }])
            ->first();

        if (!$company) {
            $company = new Company();
            
            $company->name = $user->name; 
            $company->industry = $user->job_title ?? __('strings.industry_placeholder');
            $company->description = $user->bio ?? __('strings.no_description');
            $company->address = $user->address;
            $company->phone = $user->phone;
            
            $company->logo = $user->avatar; 
            
            $company->posts = $user->posts()
                ->latest()
                ->withCount(['likes', 'comments'])
                ->get();
        }

        return view('creditor.profile', compact('company', 'user'));
    }

    /**
     * تحديث البيانات الشخصية للمستخدم
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'national_id' => 'nullable|string|max:20|unique:users,national_id,' . $user->id,
            'address' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:100',
            'bio' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($validated);

        return back()->with('success', __('strings.profile_updated_successfully'));
    }

    /**
     * تحديث بيانات الشركة (يستخدم فقط إذا كان المستخدم يملك شركة فعلية)
     */
    public function updateCompany(Request $request)
    {
        $user = Auth::user();
        $company = $user->company;

        if (!$company) {
            return redirect()->route('creditor.settings')->with('warning', __('strings.create_company_first'));
        }

        $validated = $request->validate([
            'logo' => 'nullable|image|max:2048',
            'cover_photo' => 'nullable|image|max:4096',
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'website' => 'nullable|url',
        ]);

        if ($request->hasFile('logo')) {
            if ($company->logo) Storage::disk('public')->delete($company->logo);
            $validated['logo'] = $request->file('logo')->store('companies/logos', 'public');
        }

        if ($request->hasFile('cover_photo')) {
            if ($company->cover_photo) Storage::disk('public')->delete($company->cover_photo);
            $validated['cover_photo'] = $request->file('cover_photo')->store('companies/covers', 'public');
        }

        $company->update($validated);

        return back()->with('success', __('strings.company_updated_successfully'));
    }
}