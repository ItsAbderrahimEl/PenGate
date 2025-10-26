<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class PostCreated extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected Post $post) {}

    /**
     * Get the notification's database type.
     */

    public function databaseType(object $notifiable): string
    {
        return 'post-created';
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

    public function toDatabase(object $notifiable): array {
        return [
            'post_id' => $this->post->id,
            'post_title' => $this->post->title,
            'post_user' => $this->post->user->name,
            'post_topic' => $this->post->topic->name,
        ];
    }
}
