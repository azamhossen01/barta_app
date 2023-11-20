<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostStoreRequest;

class PostController extends Controller
{

    public function store(PostStoreRequest $request)
    {
        DB::table('posts')->insert([
            'user_id' => Auth::id(),
            'uuid' => Str::uuid(),
            'description' => $request->description
        ]);
        return redirect()->back();
    }

    public function show($uuid)
    {
        $post = DB::table('posts')
        ->join('users', 'posts.user_id', '=', 'users.id')
        ->where('posts.uuid', $uuid)
        ->select('posts.*', 'users.name as author_name', 'users.username as author_username')
        ->first();
        $comments = DB::table('comments')
        ->join('users', 'comments.user_id', '=', 'users.id')
        ->select('comments.*', 'users.name', 'users.username')
        ->where('post_id', $post->id)->get();
        return view('barta.posts.show', compact('post', 'comments'));
    }

    public function edit($uuid)
    {
        $post = DB::table('posts')->where('uuid', $uuid)->first();
        return view('barta.posts.edit', compact('post'));
    }

    public function update(Request $request, $uuid)
    {
        $request->validate([
            'description' => 'required|min:20|max:10000'
        ]);
        $post = DB::table('posts')->where('uuid', $uuid)->update([
            'description' => $request->description
        ]);
        return redirect()->back();
    }

    public function destroy($uuid)
    {
        DB::table('posts')->where('uuid', $uuid)->delete();
        return redirect()->back();
    }
}
