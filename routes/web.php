<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\AdminController; 
use App\Http\Controllers\Debtor\DebtorController;
use App\Http\Controllers\Creditor\DashboardController as CreditorDashboard;
use App\Http\Controllers\Creditor\ProfileController as CreditorProfile;
use App\Http\Controllers\Creditor\PostController; 
use App\Http\Controllers\Creditor\DebtorsController;
use App\Http\Controllers\Creditor\ReportsController;
use App\Http\Controllers\CompanySettingsController;
use App\Http\Controllers\ChatController;

// ==========================================
// --- الراوت الخاص باللغة لموقعنا  ---
// ==========================================
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ar'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('switchLang');


// ==========================================
// الصفحات العامة 
// ==========================================

Route::get('/', function () { return view('index'); })->name('home');
Route::get('/about', function () { return view('about'); })->name('about');
Route::get('/contact', function () { return view('contact'); })->name('contact');
Route::get('/faq', function () { return view('faq'); })->name('faq');
Route::get('/help', function () { return view('help'); })->name('help'); 

// ==========================================
// الراوت الخاص بمصادقة الأدمن
// ==========================================
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
});


// ==========================================
// مصادقة المستخدمين 
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
    Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
    Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
});

//   راوت تسجيل الخروج
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');


// ==========================================
//  وظائف المستخدمين المسجلين من رسائل و تفاعل 
// ==========================================
Route::middleware(['auth'])->group(function () {
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::post('/posts/{id}/like', [DebtorController::class, 'toggleLike'])->name('posts.like');
    Route::post('/posts/{id}/comment', [DebtorController::class, 'storeComment'])->name('posts.comment');
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{id}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/send', [ChatController::class, 'store'])->name('chat.store');
});


// ==========================================
// لوحة تحكم الأدمن 
// ==========================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/logs', [AdminController::class, 'logs'])->name('logs');
    Route::get('/backups', [AdminController::class, 'backups'])->name('backups');
    Route::get('/companies', [AdminController::class, 'companies'])->name('companies');
    Route::post('/companies', [AdminController::class, 'storeCompany'])->name('companies.store');
    Route::patch('/companies/{id}/status', [AdminController::class, 'updateCompanyStatus'])->name('companies.status');
    Route::delete('/companies/{id}', [AdminController::class, 'deleteCompany'])->name('companies.delete');
    Route::get('/roles', [AdminController::class, 'roles'])->name('roles');
    Route::post('/roles/update', [AdminController::class, 'updatePermissions'])->name('roles.update');
    Route::post('/roles/store', [AdminController::class, 'storeRole'])->name('roles.store');
});

// ==========================================
// لوحة تحكم المدين
// ==========================================
Route::middleware(['auth', 'role:debtor'])->prefix('debtor')->name('debtor.')->group(function () {
    Route::get('/dashboard', [DebtorController::class, 'dashboard'])->name('dashboard');
    Route::get('/debts', [DebtorController::class, 'myDebts'])->name('debts');
    Route::get('/debts/{id}', [DebtorController::class, 'showDebt'])->name('debts.show');
    Route::get('/history', [DebtorController::class, 'history'])->name('history');
    Route::get('/profile', [DebtorController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [DebtorController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/update-avatar', [DebtorController::class, 'updateAvatar'])->name('profile.update_avatar');
    Route::get('/settings', [DebtorController::class, 'settings'])->name('settings');
    Route::put('/settings/profile', [DebtorController::class, 'updateProfileSettings'])->name('settings.update_profile');
    Route::put('/settings/password', [DebtorController::class, 'updatePassword'])->name('settings.update_password');
    Route::put('/settings/notifications', [DebtorController::class, 'updateNotificationSettings'])->name('settings.update_notifications');
    Route::get('/certificate/download', [DebtorController::class, 'downloadCertificate'])->name('certificate.download');
    Route::get('/notifications/{id}/read', [DebtorController::class, 'markNotificationAsRead'])->name('notifications.read');
    Route::get('/notifications/read-all', [DebtorController::class, 'markAllNotificationsAsRead'])->name('notifications.read_all');
});


// ==========================================
// لوحة تحكم الدائن 
// ==========================================
Route::middleware(['auth', 'role:creditor'])->prefix('creditor')->name('creditor.')->group(function () {
    Route::get('/dashboard', [CreditorDashboard::class, 'index'])->name('dashboard');
    Route::get('/reports', [ReportsController::class, 'index'])->name('reports');
    Route::get('/report-print/{type?}', [CreditorDashboard::class, 'report'])->name('report');
    Route::get('/search', [CreditorDashboard::class, 'search'])->name('search');
    Route::get('/history', [CreditorDashboard::class, 'history'])->name('history');
    Route::get('/debtors', [DebtorsController::class, 'index'])->name('debtors');
    Route::get('/debtors/{id}', [DebtorsController::class, 'show'])->name('debtors.show');
    Route::post('/debts/store', [CreditorDashboard::class, 'storeDebt'])->name('debts.store');
    Route::post('/payments/store', [CreditorDashboard::class, 'storePayment'])->name('payments.store');
    Route::post('/debtors/store', [CreditorDashboard::class, 'storeDebtor'])->name('debtors.store');
    Route::post('/warnings/store', [CreditorDashboard::class, 'storeWarning'])->name('warnings.store');
    Route::get('/profile', [CreditorProfile::class, 'show'])->name('profile');
    Route::put('/profile/update', [CreditorProfile::class, 'update'])->name('profile.update');
    Route::put('/company/update', [CreditorProfile::class, 'updateCompany'])->name('company.update');
    Route::get('/notifications/read', [CreditorDashboard::class, 'markNotificationsRead'])->name('notifications.read');
    Route::controller(CompanySettingsController::class)->group(function () {
        Route::get('/settings', 'index')->name('settings.index');
        Route::post('/settings/general', 'updateGeneral')->name('settings.update.general');
        Route::post('/settings/billing', 'updateBilling')->name('settings.update.billing');
        Route::post('/settings/security', 'updateSecurity')->name('settings.update.security');
    });
});