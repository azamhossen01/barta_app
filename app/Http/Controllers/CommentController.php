<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Notifications\CommentToPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'comment' => 'required|max:500'
        ]);

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'comment' => $request->comment
        ]);

        $post->user->notify(new CommentToPost($comment));

        
        return redirect()->back();
    }

    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'edit_comment' => 'required'
        ]);
        $comment->update([
            'comment' => $request->edit_comment
        ]);
        
        return redirect()->back();
    }
}
