<?php 

if (!function_exists('check_post_like_status')) {
    function check_post_like_status($type, $notifiable_type) {
        return $type->notifications()->where('type', $notifiable_type)->where('data->post_id', $type->id)->where('data->liked_by', auth()->id())->exists();
    }
}

if (!function_exists('get_liker_of_post')) {
    function get_liker_of_post($post, $notification_type) {
        return $post->notifications()->where('type', $notification_type)->where('data->post_id', $post->id)->first()->data['liked_by'];
    }
}

if (!function_exists('read_single_notification')) {
    function read_single_notification($noti, $post_id) {
        // return $post->unreadNotifications;
        foreach($noti->unreadNotifications as $notification){
            // return $notification;
            if($noti->id === $notification->notifiable_id && $post_id === $notification->data['post_id']){
                // return $notification;
                $notification->markAsRead();
            }
        }
    }
}