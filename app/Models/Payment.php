<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'transaction_id',
        'creditor_id',
        'debtor_id',
        'debt_id',
        'amount',
        'method', 
        'paid_at',
        'notes',
        'reference_number'
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function debtor()
    {
        return $this->belongsTo(User::class, 'debtor_id');
    }

    public function creditor()
    {
        return $this->belongsTo(User::class, 'creditor_id');
    }

    public function debt()
    {
        return $this->belongsTo(Debt::class);
    }
}