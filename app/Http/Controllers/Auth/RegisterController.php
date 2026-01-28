<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;           
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/dashboard'; 

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * دالة التسجيل المعدلة لمنع الدخول التلقائي
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));


        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return redirect()->route('login')->with('success', 'تم إنشاء الحساب بنجاح! يرجى تسجيل الدخول.');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'string', 'unique:users'], 
            'address' => ['required', 'string', 'max:255'],
            'owner_name' => ['nullable', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'role' => ['nullable', 'string'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'address' => $data['address'],
            'role' => $data['role'] ?? 'debtor',
            'owner_name' => $data['owner_name'] ?? null,
            'company_name' => $data['company_name'] ?? null,
        ]);
    }
}