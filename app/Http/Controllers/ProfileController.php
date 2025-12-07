<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        return view('profiles.show', compact('user'));
    }

    public function edit()
    {
        $user = auth()->user();
        return view('profiles.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'username' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('users')->ignore($user->id),
            ],
            'birthday' => 'nullable|date',
            'bio' => 'nullable|string|max:1000',
            'profile_photo' => 'nullable|image|max:2048',
            'password' => 'nullable|confirmed|min:8',
        ]);

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            $user->profile_photo_path = $request->file('profile_photo')->store('profiles', 'public');
        }

        $user->username = $validated['username'] ?? $user->username;
        $user->birthday = $validated['birthday'] ?? $user->birthday;
        $user->bio = $validated['bio'] ?? $user->bio;

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return back()->with('success', 'Profile updated.');
    }
}
