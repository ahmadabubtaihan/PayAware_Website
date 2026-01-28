<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * عرض صفحة تسجيل الدخول
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * معالجة طلب تسجيل الدخول
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            
            $request->session()->regenerate();

            return $this->redirectUserBasedOnRole();
        }

        return back()->withErrors([
            'email' => __('auth.failed'),
        ])->onlyInput('email');
    }

    /**
     * دالة مساعدة لتوجيه المستخدم بناءً على رتبته (Role)
     */
    protected function redirectUserBasedOnRole()
    {
        $role = Auth::user()->role;

        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        } 
        elseif ($role === 'creditor') {
            return redirect()->route('creditor.dashboard');
        } 
        elseif ($role === 'debtor') {
            return redirect()->route('debtor.dashboard');
        }

        return redirect()->route('home');
    }

    /**
     * تسجيل الخروج
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}