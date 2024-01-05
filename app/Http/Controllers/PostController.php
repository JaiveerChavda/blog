<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
                request(['search','category','author'])
                )->paginate(6)
                ->withQueryString(),
        ]);
    }

    public function show(Post $post)
    {
        //show 404 response if post is in draft mode

        abort_if($post->status == 'draft',404);

        return view('posts.show', [
            'post' => $post
        ]);
    }

    public function showPostsFeed(Post $post)
    {
        return $post;
    }

}
