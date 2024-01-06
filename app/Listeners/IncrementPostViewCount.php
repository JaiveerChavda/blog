<?php

namespace App\Listeners;

use App\Events\PostViewed;
use App\Models\Post;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Session\Store;

class IncrementPostViewCount
{
    /**
     * Create the event listener.
     */
    public function __construct(private Store $session)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PostViewed $event): void
    {
        if(! $this->isPostViewed($event->post))
        {
            $post = Post::findOrFail($event->post->id);

            $post->view_count += 1;

            $post->save();

            $this->storePostInSession($post);
        }

    }

    public function isPostViewed($post)
    {
        // dd($post);
        // Get all the viewed posts from the session. If no
        // entry in the session exists, default to an
        // empty array.
        $viewed = $this->session->get('viewed_posts', []);

        // Check the viewed posts array for the existance
        // of the id of the post
        return in_array($post->id, $viewed);
    }

    public function storePostInSession($post)
    {
        // Push the post id onto the viewed_posts session array.
        $this->session->push('viewed_posts', $post->id);
    }
}
