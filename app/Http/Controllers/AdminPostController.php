<?php

namespace App\Http\Controllers;

use App\Enums\PostStatus;
use App\Events\PostPublished as EventsPostPublished;
use App\Models\Post;
use App\Models\User;
use App\Notifications\PostPublished;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class AdminPostController extends Controller
{
    //
    public function index()
    {
        return view('admin.posts.index',[
            'posts' => Post::latest()->paginate(50)
        ]);
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    //publish the given post

    public function store()
    {
        if (request('action') == 'save_as_draft') {

            $post = Post::create(array_merge($this->validatePost(), [
                'user_id' => request()->user()->id,
                'thumbnail' =>  request()->file('thumbnail')->store('thumbnails'),
                'status' => PostStatus::DRAFT->value,
             ]
            ));

            return Redirect::route('admin.posts.index')->with('success','post saved as draft');

        }else{
            $post = Post::create(array_merge($this->validatePost(), [
                'user_id' => request()->user()->id,
                'thumbnail' => request()->file('thumbnail')->store('thumbnails'),
                'status' => PostStatus::PUBLISHED->value,
                'published_at' => now(),
            ]
            ));

            event(new EventsPostPublished($post));

            return redirect('/')->with('success','post published successfuly');
        }
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit',[
            'authors' => User::all(['id','name']),
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

        if($attributes['status'] == PostStatus::PUBLISHED->value && $post->published_at == null)
        {
            $post->published_at = now();
            $post->save();
            event(new EventsPostPublished($post));
        }

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
            'status' => $post->exists ? ['required'] : ['nullable'],
            'user_id' => $post->exists ? ['required',Rule::exists('users','id')] : ['nullable'],
        ]);
    }
}
