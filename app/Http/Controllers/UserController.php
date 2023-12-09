<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    public function authorProfile($username)
    {
        $username = Crypt::decrypt($username);
        
        $user = User::with([
            'posts' => function ($query) {
                $query->withCount('comments');
            },
        ])->where('username', $username)->first();

        return view('barta.posts.author', compact('user'));
    }
}
