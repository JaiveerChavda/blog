<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    //
    public function create()
    {
        return view('session.create');
    }

    public function store()
    {
        //validate the  request
        $attributes = request()->validate([
            'email' => ['required','exists:users,email'],
            'password' => ['required']
        ]);

        //attempt to authenticate and log in the user
        //based on the provided credentials.
        if(auth()->attempt($attributes)){
            session()->regenerate();
            return redirect('/')->with('success','Welcome Back!');
        }

        //newer and advance way to flash validation error
        throw ValidationException::withMessages([
            'email'=>'your provided credentials could not be verified.'
        ]);

        //1st and basic way to flash validation error
        // return back()
        //         ->withInput()
        //         ->withErrors(['email'=>'your provided credentials could not be verified.']);
    }

    public function destroy()
    {
        auth()->logout();

        return redirect('/')->with('success','Goodbye!');
    }
}
