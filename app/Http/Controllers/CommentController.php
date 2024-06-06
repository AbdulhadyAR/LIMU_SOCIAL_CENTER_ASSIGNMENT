<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post; 
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function store(Request $request, Post $post)
    {
        $this->validate($request, [
            'content' => ['required', 'string', 'min:3', 'max:1000']
        ]);

        Comment::create([
            'content' => $request->content,
            'post_id' => $post->id,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->back()->with('success', 'Comment added successfully.');
    }


    public function update(Request $request, Comment $comment)
    {
        $this->validate($request, [
            'content' => ['required', 'string', 'min:3', 'max:1000']
        ]);

        $this->authorize('update', $comment); // Ensure the user is authorized to update the comment

        $comment->update([
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Comment updated successfully.');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment); // Ensure the user is authorized to delete the comment

        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }
}
