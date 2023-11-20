<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $uuid)
    {
        $request->validate([
            'comment' => 'required|min:10|max:500'
        ]);
        $post = DB::table('posts')->where('uuid', $uuid)->first();
        $comment = DB::table('comments')->insert([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'comment' => $request->comment
        ]);
        return redirect()->back();
    }
}
