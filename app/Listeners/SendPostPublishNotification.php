<?php

namespace App\Listeners;

use App\Events\PostPublished;
use App\Notifications\PostPublished as NotificationsPostPublished;
use Illuminate\Support\Facades\Notification;

class SendPostPublishNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PostPublished $event): void
    {
        Notification::send($event->post->author->followers, new NotificationsPostPublished($event->post));
    }
}
