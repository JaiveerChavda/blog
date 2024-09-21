<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirect()
    {
        $driver = request()->get('type');
        return Socialite::driver($driver)->redirect();
    }

    public function callback()
    {
        $type = request()->get('type');

        $socialUser = Socialite::driver($type)->user();

        $type_id = $type . '_id';

        $user = User::updateOrCreate([
            'email' => $socialUser->email,
        ], [
            $type_id => $socialUser->id,
            'username' => explode(" ", $socialUser->name)[0],
            'name' => $socialUser->name,
            'email' => $socialUser->email,
            'avatar' => $socialUser->avatar,
            'email_verified_at' => now(),
            'first_social_login_by' => $type,
            'last_authenticated_at' => now(),
            'last_authenticated_by' => $type,
        ]);

        Auth::login($user);

        return redirect('/')->with('success',"$type login successfull");
    }
}
