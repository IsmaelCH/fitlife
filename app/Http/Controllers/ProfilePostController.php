<?php

namespace App\Http\Controllers;

use App\Models\ProfilePost;
use App\Models\User;
use Illuminate\Http\Request;

class ProfilePostController extends Controller
{
    public function store(Request $request, User $user)
    {
        $validated = $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        ProfilePost::create([
            'profile_user_id' => $user->id,
            'author_user_id' => $request->user()->id,
            'body' => $validated['body'],
        ]);

        return redirect()->route('profiles.show', $user)->with('success', 'Message posted.');
    }

    public function destroy(ProfilePost $post)
    {
        $user = auth()->user();

        // Admin OR author OR profile owner can delete
        if (
            ! $user->can('admin') &&
            $post->author_user_id !== $user->id &&
            $post->profile_user_id !== $user->id
        ) {
            abort(403);
        }

        $profileId = $post->profile_user_id;
        $post->delete();

        return redirect()->route('profiles.show', $profileId)->with('success', 'Message deleted.');
    }
}
