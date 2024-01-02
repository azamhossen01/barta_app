<?php

namespace App\Livewire;

use App\Models\Post;
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
        return view('livewire.all-posts', ['posts' => $posts]);
    }
}
