<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    public function index()
    {
        return view('posts', [
            'posts' => Post::latest()->filter(request(['search','category']))->get(),
            'categories' => Category::all(),
            'currentCategory' => Category::firstWhere('slug',request('category'))
        ]);
    }

    public function show(Post $post)
    {
        return view('post',[
            'post' => $post
        ]);
    }

}
