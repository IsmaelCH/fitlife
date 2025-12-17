<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Publiek profiel
    public function show(User $user)
    {
        return view('profiles.show', compact('user'));
    }

    // Eigen profiel bewerken
    public function edit()
    {
        $user = Auth::user();
        return view('profiles.edit', compact('user'));
    }

    // Opslaan
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'username' => 'nullable|string|max:255',
            'birthday' => 'nullable|date',
            'bio' => 'nullable|string|max:1000',
            'profile_photo' => 'nullable|image|max:2048',
        ]);

        // Profielfoto uploaden
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')
                ->store('profiles', 'public');

            $validated['profile_photo_path'] = $path;
        }

        $user->update($validated);

        return redirect()
            ->route('profiles.show', $user)
            ->with('success', 'Profile updated');
    }
}
