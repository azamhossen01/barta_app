<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Termwind\Components\Raw;

class WelcomeController extends Controller
{
    public function index()
    {
        // $posts = DB::table('posts')
        // ->join('users', 'posts.user_id', '=', 'users.id')
        // ->leftJoin('comments', 'posts.id', '=', 'comments.post_id')
        // ->select('users.name', 'users.username', 'posts.description', 'posts.uuid', 'posts.user_id', 'posts.id', 'posts.created_at', DB::raw('COUNT(comments.id) as comment_count'))
        // ->groupBy('users.name', 'posts.id')
        // ->orderBy('posts.id', 'desc')
        // ->paginate(10);
        $posts = Post::with('user', 'comments')->orderBy('id','desc')->paginate();
        // return $posts;
        return view('welcome', compact('posts'));
    }
}
