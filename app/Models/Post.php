<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth; 
class Post extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'user_id', 'content', 'image', 'is_offer', 'likes_count'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'post_likes', 'post_id', 'user_id');
    }

    public function isLikedByAuthUser()
    {
        if (!Auth::check()) {
            return false;
        }
        return $this->likes()->where('user_id', Auth::id())->exists();
    }
}