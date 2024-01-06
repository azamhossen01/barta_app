<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Notifications\LikeToPost;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostStoreRequest;
use Illuminate\Support\Facades\Notification;

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
        
        if(check_post_like_status($post, "App\Notifications\LikeToPost")){
            
        }
        
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

    public function likePost(Post $post)
    {
        // return $post->notifications()->where('type', "App\Notifications\LikeToPost")->count();
        // return $post->notifications()->where('type', LikeToPost::class)->where('data->post_id', $post->id)->get();
        // return $post->notifications()->where('type', LikeToPost::class)->count();
        // check_post_like_status($post, "App\Notifications\LikeToPost");
        if (!check_post_like_status($post, "App\Notifications\LikeToPost")) {
            $post->user->notify(new LikeToPost($post));
            $post->notify(new LikeToPost($post));
        }else{
            $post->notifications()->where('type', LikeToPost::class)->where('data->post_id', $post->id)->where('data->liked_by', Auth::id())->first()->delete();
        }
        return redirect()->back();
    }

    // public function unlikePost(Post $post)
    // {
    //     if (!check_post_like_status($post, "App\Notifications\LikeToPost")) {
    //         $post->user->notify(new LikeToPost($post));
    //         // auth()->user()->notify(new LikeToPost($post));
    //         $post->notify(new LikeToPost($post));
    //     }else{
    //         $post->notifications()->where('type', LikeToPost::class)->where('data->post_id', $post->id)->where('data->liked_by', Auth::id())->first()->delete();
    //     }
    //     return redirect()->back();
    // }
}
