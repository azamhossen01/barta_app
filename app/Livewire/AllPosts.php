<?php

namespace App\Livewire;

use App\Models\Post;
use App\Notifications\LikeToPost;
use Livewire\Component;

class AllPosts extends Component
{

    public $counter = 5;

    public function loadMore()
    {
        $this->counter += 5;
    }

    public function render()
    {
        $posts = Post::with('user', 'comments')->orderBy('id','desc')->take($this->counter)->get();
        // $notifications = auth()->user()->notifications->pluck('notifiable_id');
        $notifications = auth()->user()->notifications->where('type', LikeToPost::class)->pluck('data');
        // return $notifications;
        return view('livewire.all-posts', ['posts' => $posts, 'notifications' => $notifications]);
    }
}
