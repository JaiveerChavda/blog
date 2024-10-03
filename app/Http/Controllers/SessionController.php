<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    //
    public function create()
    {
        return view('session.create');
    }

    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()
            ->intended(RouteServiceProvider::HOME)
            ->with('success','welcome back!');
    }

    public function destroy()
    {
        auth()->logout();

        return redirect('/')->with('success','Goodbye!');
    }
}
