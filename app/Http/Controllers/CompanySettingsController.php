<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CompanySettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('creditor.settings', compact('user'));
    }

    public function updateGeneral(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|unique:users,phone,' . $user->id,
            'address' => 'required|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $path;
        }

        $user->update($validated);

        return back()->with('success', __('strings.settings_updated_successfully'));
    }

    public function updateBilling(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'currency' => 'required|string|in:USD,ILS,JOD',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'invoice_footer_note' => 'nullable|string|max:500',
        ]);

        $user->update($validated);

        return back()->with('success', __('strings.billing_updated_successfully') ?? 'Billing updated');
    }

    public function updateSecurity(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'nullable|required_with:new_password|current_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        if ($request->filled('new_password')) {
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);
        }

        $user->update([
            'two_factor_enabled' => $request->has('two_factor_enabled')
        ]);

        return back()->with('success', __('strings.security_updated_successfully') ?? 'Security settings updated');
    }
}