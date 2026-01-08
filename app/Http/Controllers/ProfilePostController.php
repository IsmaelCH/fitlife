<?php

namespace App\Http\Controllers;

use App\Models\ProfilePost;
use App\Models\User;
use Illuminate\Http\Request;

class ProfilePostController extends Controller
{
    public function show(ProfilePost $post)
    {
        // Si es una petición AJAX, devolver JSON
        if (request()->wantsJson() || request()->ajax()) {
            $post->load(['author', 'comments.user']);
            return response()->json([
                'id' => $post->id,
                'body' => $post->body,
                'author' => [
                    'name' => $post->author->username ?? $post->author->name,
                ],
                'created_at' => $post->created_at->format('M d, Y \\a\\t H:i'),
                'created_at_human' => $post->created_at->diffForHumans(),
                'comments' => $post->comments->map(function($comment) {
                    return [
                        'id' => $comment->id,
                        'body' => $comment->body,
                        'user' => [
                            'id' => $comment->user_id,
                            'name' => $comment->user->username ?? $comment->user->name,
                        ],
                        'created_at_human' => $comment->created_at->diffForHumans(),
                        'can_delete' => auth()->check() && (auth()->user()->can('admin') || auth()->id() === $comment->user_id),
                    ];
                }),
            ]);
        }
        
        abort(404);
    }

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
