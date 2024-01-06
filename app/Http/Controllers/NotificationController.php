<?php

namespace App\Http\Controllers;

use App\Notifications\LikeToPost;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function notificationSeen($id)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->first();
        $notification->markAsRead();
        return redirect()->route('posts.show', $notification->data['post_uuid']);
    }
}
