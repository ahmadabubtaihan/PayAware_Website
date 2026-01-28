<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'logo', 'cover_photo', 'industry', 
        'address', 'phone', 'website', 'description', 
        'rating'
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}