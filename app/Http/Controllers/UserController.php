<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    /**
     * follow the given author.
     */
    public function follow(User $author)
    {
        try {
            $author->followers()->attach(auth()->id());

            return redirect()->back()->with('success', 'you are now following '.$author->name);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * un-follow the given author.
     */
    public function unFollow(User $author)
    {
        try {
            $author->followers()->detach(auth()->id());

            return redirect()->back()->with('success', 'you unfollowed '.$author->name);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * return a view containing current user's followers list
     */
    public function followers()
    {
        $user = Auth::user();

        return view('user.followers', [
            'followers' => $user->followers,
        ]);
    }

    public function followings()
    {
        $user = Auth::user();

        // dd($user->followings);
        return view('user.followings', [
            'followings' => $user->followings,
        ]);
    }

    /**
     * remove the given user from the author
     * followers list
     */
    public function remove(User $follower)
    {
        $user = Auth::user();

        try {
            $user->followers()->detach($follower->id);

            return redirect()->back()->with('success', "successfully removed $follower->username");
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }

    }
}
