<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Termwind\Components\Raw;
use App\Notifications\LikeToPost;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function index()
    {
        
        // $notifications = auth()->user()->notifications->where('type', LikeToPost::class)->pluck('data');
        // return $notifications[0]['post_id'];
        // $posts = Post::with('user', 'comments')->orderBy('id','desc')->paginate(10);
        // $notifications = auth()->user()->notifications->pluck('notifiable_id');
        // return $notifications;
        // return auth()->user()->notifications;
        return view('welcome');
    }
}
