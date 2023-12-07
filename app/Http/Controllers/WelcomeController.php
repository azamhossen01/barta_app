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
        $posts = Post::with('user', 'comments')->orderBy('id','desc')->paginate(10);
        return view('welcome', compact('posts'));
    }
}
