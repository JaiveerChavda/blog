<?php

namespace App\Http\Controllers;

use App\Events\PostViewed;
use App\Models\Post;

class PostController extends Controller
{
    //
    public function index()
    {
        return view('posts.index', [
            'posts' => Post::query()
                ->latest()
                ->published()
                ->filter(
                    request(['search', 'category', 'author'])
                )->paginate(6)
                ->withQueryString(),
        ]);
    }

    public function show(Post $post)
    {
        // show 404 response if post is in draft mode

        abort_if($post->status == 'draft', 404);

        $user = auth()->user();

        $is_post_bookmarked = $user?->bookmarked_posts ? in_array($post->id, $user->bookmarked_posts) : false;

        event(new PostViewed($post));

        return view('posts.show', [
            'post' => $post,
            'is_post_bookmarked' => $is_post_bookmarked,
        ]);
    }

    public function showPostsFeed(Post $post)
    {
        return $post;
    }
}
