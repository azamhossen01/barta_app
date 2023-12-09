<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostStoreRequest;

class PostController extends Controller
{

    public function store(PostStoreRequest $request)
    {
        $post = Post::create([
            'user_id' => Auth::id(),
            'uuid' => Str::uuid(),
            'description' => $request->description,
        ]);

        if($request->hasFile('featured_image')){
            $post->addMedia($request->featured_image)->toMediaCollection('featured_image');
        }
       
        return redirect()->back();
    }

    public function show(Post $post)
    {
        $post->increment('view_count');
        
        return view('barta.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('barta.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'description' => 'required|min:20|max:10000',
            'featured_image' => 'mimes:png,jpg|max:1024'
        ]);

        $post->update([
            'description' => $request->description
        ]);

        if($request->hasFile('featured_image')){
            $post->clearMediaCollection('featured_image');
            $post->addMedia($request->featured_image)->toMediaCollection('featured_image');
        }

        return redirect()->back();
    }

    public function destroy(Post $post)
    {
        if($post){

            $post->delete();

            if($post->hasMedia('featured_image')){

                $post->clearMediaCollection('featured_image');
                
            }
        }
        
        return redirect()->back();
    }
}
