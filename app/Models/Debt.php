<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Debt extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'transaction_id',
        'creditor_id',
        'debtor_id',
        'amount',
        'remaining_amount',
        'due_date',
        'description',
        'status',
    ];

    public function debtor()
    {
        return $this->belongsTo(User::class, 'debtor_id');
    }

    public function creditor()
    {
        return $this->belongsTo(User::class, 'creditor_id');
    }
}