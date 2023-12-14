<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminPostController extends Controller
{
    //
    public function index()
    {
        return view('admin.posts.index',[
            'posts' => Post::paginate(50)
        ]);
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store()
    {
        Post::create(array_merge($this->validatePost(), [
            'user_id' => request()->user()->id,
            'thumbnail' =>  request()->file('thumbnail')->store('thumbnails'),
         ]
        ));

        return redirect('/');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit',[
            'post' => $post,
        ]);
    }

    public function update(Post $post)
    {
        $attributes = $this->validatePost($post);

        if($attributes['thumbnail'] ?? false){
            $attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnails');
        }

        $post->update($attributes);

        return back()->with('success','post updated');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return back()->with('success','post deleted!');
    }

    protected function validatePost(?Post $post = null)
    {
        $post ??= new Post();

        return request()->validate([
            'title' => ['required'],
            'slug' => ['required',Rule::unique('posts','slug')->ignore($post)],
            'thumbnail' => $post->exists ? ['image'] : ['required','image'],
            'excerpt' => ['required'],
            'body' => ['required'],
            'category_id' => ['required',Rule::exists('categories','id')],
        ]);
    }
}
