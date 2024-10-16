<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        return view('user.profile.index', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $profile)
    {
        return view('user.profile.edit', [
            'user' => $profile,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(User $profile)
    {
        $validated = request()->validate([
            'name' => ['string', 'max:255'],
            'username' => ['string', 'max:255', Rule::unique('users')->ignore($profile->id)],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($validated['avatar'] ?? false) {
            $validated['avatar'] = request()->file('avatar')->store('user/avatar');
        }

        $profile->update($validated);

        return redirect()->route('profile.index')->with('success', 'profile updated successfully');
    }
}
