<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    //
    public function create()
    {
        return view('register.create');
    }

    public function store()
    {
        $attributes = request()->validate([
            'name' => ['required','max:255'],
            'username' => ['required','min:3','max:255'],
            'email' => ['required','email','max:255'],
            'password' => ['required','max:255','min:8']
        ]);

        User::create($attributes);

        return redirect('/');
    }
}
