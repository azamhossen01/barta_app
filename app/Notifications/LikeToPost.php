<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class LikeToPost extends Notification
{
    use Queueable;
    public $post;
    /**
     * Create a new notification instance.
     */
    public function __construct($post)
    {
        $this->post = $post;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => Auth::id() === $this->post->user_id ? 'You like your own post' : Auth()->user()->name . ' like your post',
            'link' => route('posts.show', $this->post->uuid),
            'post_id' => $this->post->id,
            'post_uuid' => $this->post->uuid,
            'liked_by' => Auth::id()
        ];
    }
}
