<?php

namespace App\Http\Controllers\Creditor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * حفظ منشور جديد
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        

        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'is_offer' => 'nullable|boolean',
        ]);

        $post = new Post();
        
        $post->company_id = $user->company_id; 
        
        $post->user_id = $user->id;
        $post->content = $validated['content'];
        $post->is_offer = $request->has('is_offer'); 

        if ($request->hasFile('image')) {
            $post->image = $request->file('image')->store('posts', 'public');
        }

        $post->save();

        return back()->with('success', __('strings.post_published_successfully'));
    }
}