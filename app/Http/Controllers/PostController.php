<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::with('user', 'likes')->orderBy('created_at', 'desc')->get();
        return view('users.posts.index', compact('posts'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => ['required', 'string', 'min:3', 'max:1000']
        ]);

        Post::create([
            'content' => $request->content,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->back();
    }


    public function update(Request $request, Post $post)
    {
        $this->validate($request, [
            'content' => ['required', 'string', 'min:3', 'max:1000']
        ]);

        $this->authorize('update', $post); // Ensure the user is authorized to update the post

        $post->update([
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post); // Ensure the user is authorized to delete the post

        $post->delete();

        return redirect()->back()->with('success', 'Post deleted successfully.');
    }


    public function storeComment(Request $request, Post $post)
    {
        $this->validate($request, [
            'content' => ['required', 'string', 'min:3', 'max:1000']
        ]);

        Comment::create([
            'content' => $request->content,
            'post_id' => $post->id,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->back();
    }
}
