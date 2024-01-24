<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BookmarkPostController extends Controller
{
    public function store()
    {
        $validate = request()->validate([
            'postId' => ['required','integer','exists:posts,id'],
        ]);

        $user = auth()->user();

        $post_id = (int) $validate['postId'];

        if(is_null($user->bookmarked_posts)) {
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
        try {

            $user = auth()->user();

            $bookmarks = $user->bookmarked_posts;

            if($key = array_search($bookmark->id, $bookmarks)) {
                unset($bookmarks[$key]);

                $user->bookmarked_posts = $bookmarks;

                $user->save();

                return back()->with('success','post removed from bookmarks');
            }
        } catch (\Exception $e) {
            return back()->with('error','something went wrong');
        }
    }
}
