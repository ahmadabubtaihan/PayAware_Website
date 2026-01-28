<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * عرض صفحة تسجيل دخول الأدمن
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * معالجة طلب الدخول
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        // 2. محاولة  الدخول
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->remember)) {
            
            $user = Auth::user();
            
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                Auth::logout();
                return back()->with('error', 'غير مصرح لك بالدخول من هنا. هذه لوحة الإدارة فقط.');
            }
        }

        return back()->withInput($request->only('email'))->with('error', 'بيانات الاعتماد غير صحيحة.');
    }

    /**
     * تسجيل الخروج
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}