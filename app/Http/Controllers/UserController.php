<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    /**
     * follow the given author.
     *
     */
    public function follow(User $author)
    {
        try {
            $author->followers()->attach(auth()->id());

            return redirect()->back()->with('success',"you are now following ".$author->name);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error','Something went wrong!');
        }
    }

    /**
     * un-follow the given author.
     *
     */

    public function unFollow(User $author)
    {
        try {
            $author->followers()->detach(auth()->id());

            return redirect()->back()->with('success',"you unfollowed ".$author->name);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error','Something went wrong!');
        }
    }
}
