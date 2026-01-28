<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'account_id',

        'name',
        'email',
        'password',
        'phone',
        'national_id',
        'address',
        
        'company_id',
        'role',          
        'company_role',  
        
        'owner_name',
        'company_name',

        'job_title',
        'bio',
        'work_place',
        'study_place',
        'avatar',
        'google_id',

        'credit_score',
        'risk_level',

        'is_active',
        'two_factor_enabled',
        'notification_preferences',

        'currency',
        'tax_rate',
        'invoice_footer_note',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'notification_preferences' => 'array',
        'is_active' => 'boolean',
        'two_factor_enabled' => 'boolean',
    ];

    // =============================================
    // =============================================

    
    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->account_id)) {
                $user->account_id = self::generateUniqueAccountId();
            }
        });
    }

   
    public static function generateUniqueAccountId()
    {
        do {
            $code = mt_rand(100000, 999999);
        } while (self::where('account_id', $code)->exists()); 

        return (string) $code;
    }


    /**
     *  العلاقة مع الشركة
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     *  العلاقة مع المنشورات
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     *  الديون التي "على" المستخدم (بصفته مديناً - Debtor)
     */
    public function debtsAsDebtor(): HasMany
    {
        return $this->hasMany(Debt::class, 'debtor_id');
    }

    /**
     *  الديون التي "للمستخدم" (بصفته دائناً - Creditor)
     */
    public function debtsAsCreditor(): HasMany
    {
        return $this->hasMany(Debt::class, 'creditor_id');
    }

    /**
     *  المدفوعات التي قام بها المستخدم (سداد)
     */
    public function paymentsMade(): HasMany
    {
        return $this->hasMany(Payment::class, 'debtor_id');
    }

    /**
     *  المدفوعات التي استلمها المستخدم (تحصيل)
     */
    public function paymentsReceived(): HasMany
    {
        return $this->hasMany(Payment::class, 'creditor_id');
    }

    /**
     *  الرسائل المرسلة
     */
    public function messagesSent(): HasMany
    { 
        return $this->hasMany(Message::class, 'sender_id'); 
    }

    /**
     * الرسائل المستلمة
     */
    public function messagesReceived(): HasMany 
    { 
        return $this->hasMany(Message::class, 'receiver_id'); 
    }
}