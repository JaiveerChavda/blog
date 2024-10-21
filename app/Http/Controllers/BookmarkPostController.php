<?php

namespace App\Http\Controllers;

use App\Models\Post;

class BookmarkPostController extends Controller
{
    public function index()
    {
        $bookmarked_post_ids = request()->user()->bookmarked_posts;

        $posts = $bookmarked_post_ids ? Post::whereIn('id', $bookmarked_post_ids)->get() : null;

        return view('user.reading-list', [
            'saved_posts' => $posts,
            'recommended_posts' => Post::query()
                ->whereNotIn('id', $bookmarked_post_ids)
                ->select(['title', 'slug', 'id'])
                ->published()
                ->limit(10)
                ->get(),
        ]);
    }

    public function store()
    {
        $validate = request()->validate([
            'postId' => ['required', 'integer', 'exists:posts,id'],
        ]);

        $user = auth()->user();

        $post_id = (int) $validate['postId'];

        if (is_null($user->bookmarked_posts)) {
            $user->bookmarked_posts = [$post_id];
        } else {
            $bookmarks = $user->bookmarked_posts;
            array_push($bookmarks, $post_id);
            $user->bookmarked_posts = $bookmarks;
        }

        $user->save();

        return back()->with('success', 'post added to reading list');
    }

    public function destroy(Post $bookmark)
    {

        $user = auth()->user();

        $bookmarks = $user->bookmarked_posts;

        if (($key = array_search($bookmark->id, $bookmarks)) !== false) {
            unset($bookmarks[$key]); // Remove the post from bookmarks

            $user->bookmarked_posts = array_values($bookmarks); // reindex array

            $user->save();

            return back()->with('success', 'post removed from reading list.');
        }

        return back()->with('error', 'Post not found in bookmarks.');
    }
}
