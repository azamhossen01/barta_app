<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    public function authorProfile($username)
    {
        $username = Crypt::decrypt($username);
        $author = DB::table('users')->where('username', $username)->first();
        $posts = DB::table('posts')
        ->join('users', 'posts.user_id', '=', 'users.id')
        ->select('posts.*', 'users.name', 'users.username')
        ->where('user_id', $author->id)
        ->paginate(10);
        $comments = DB::table('comments')->where('user_id', $author->id)->get();
        return view('barta.posts.author', compact('author', 'posts', 'comments'));
    }
}
