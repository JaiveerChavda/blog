<?php

namespace App\Http\Controllers;

use App\Enums\PostStatus;
use App\Events\PostPublished as EventsPostPublished;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class AdminPostController extends Controller
{
    public function index()
    {

        $user = request()->user();

        $is_admin = request()->user()?->can('admin');

        $posts = $is_admin ? Post::latest()->paginate(50) : $user->posts;

        return view('admin.posts.index', [
            'posts' => $posts,
        ]);
    }

    public function create()
    {
        return view('admin.posts.create', [
            'categories' => Category::all(['id', 'name']),
        ]);
    }

    //publish the given post

    public function store()
    {
        if (request('action') == 'save_as_draft') {

            $post = Post::create(array_merge(
                $this->validatePost(),
                [
                    'user_id' => request()->user()->id,
                    'thumbnail' => request()->file('thumbnail')->store('thumbnails'),
                    'status' => PostStatus::DRAFT->value,
                ]
            ));

            return Redirect::route('admin.posts.index')->with('success', 'post saved as draft');

        } else {
            $post = Post::create(array_merge(
                $this->validatePost(),
                [
                    'user_id' => request()->user()->id,
                    'thumbnail' => request()->file('thumbnail')->store('thumbnails'),
                    'status' => PostStatus::PUBLISHED->value,
                    'published_at' => now(),
                ]
            ));

            event(new EventsPostPublished($post));

            return redirect('/')->with('success', 'post published successfuly');
        }
    }

    public function edit(Post $post)
    {
        //authorise that current user owns this post and is able to edit this post .
        //only admin and the author of the post can edit the post
        if (request()->user()?->can('admin') == true || auth()->id() == $post->author->id) {
            return view('admin.posts.edit', [
                'authors' => User::all(['id', 'name']),
                'post' => $post,
            ]);

        }

        abort(Response::HTTP_FORBIDDEN, 'Your are not Authorized to perform this action');

    }

    public function update(Post $post)
    {
        $attributes = $this->validatePost($post);

        if ($attributes['thumbnail'] ?? false) {
            $attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnails');
        }

        $post->update($attributes);

        if ($attributes['status'] == PostStatus::PUBLISHED->value && $post->published_at == null) {
            $post->published_at = now();
            $post->save();
            event(new EventsPostPublished($post));
        }

        return redirect()
            ->route('admin.posts.edit', ['post' => $post->slug])
            ->with('success', 'post updated');
    }

    public function destroy(Post $post)
    {
        //authorise that current user owns this post and is able to delete this post
        //only admin and the author of the post can delete the post

        if (request()->user()?->can('admin') == true || auth()->id() == $post->author->id) {

            $post->delete();

            return redirect()
                ->route('admin.posts.index')
                ->with('success', 'post deleted!');

        }

        abort(403, 'Your are not Authorized to perform this action');

    }

    protected function validatePost(?Post $post = null)
    {
        //if post not passed in argument the create new post object
        $post ??= new Post;

        return request()->validate([
            'title' => ['required', 'max:100'],
            'slug' => ['required', 'max:120', Rule::unique('posts', 'slug')->ignore($post)],
            'thumbnail' => $post->exists ? ['image'] : ['required', 'image'],
            'excerpt' => ['required','min:10'],
            'body' => ['required','min:10'],
            'category_id' => ['required', Rule::exists('categories', 'id')],
            'status' => $post->exists ? ['required'] : ['nullable'],
        ]);
    }
}
