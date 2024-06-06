<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostLike;
use App\Models\User;
use Illuminate\Http\Request;

class PostLikeController extends Controller
{
    public function toggleLike(Post $post, User $user) {

        // for creating
        if (! PostLike::where('post_id', $post->id)->where('user_id', $user->id)->exists()) {
            PostLike::create([
                'post_id' => $post->id,
                'user_id' => $user->id,
            ]);
        } else {
            PostLike::where('post_id', $post->id)
                ->where('user_id', $user->id)
                ->delete();
        }

        return redirect()->route('posts.index');
    }
}
