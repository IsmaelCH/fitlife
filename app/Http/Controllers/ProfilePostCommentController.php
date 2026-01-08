<?php

namespace App\Http\Controllers;

use App\Models\ProfilePost;
use App\Models\ProfilePostComment;
use Illuminate\Http\Request;

class ProfilePostCommentController extends Controller
{
    public function store(Request $request, ProfilePost $post)
    {
        $validated = $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $post->comments()->create([
            'user_id' => $request->user()->id,
            'body' => $validated['body'],
        ]);

        return redirect()->back()->with('success', 'Comment added.');
    }

    public function destroy(ProfilePostComment $comment)
    {
        $user = auth()->user();

        // Admin or owner can delete
        if (! $user->can('admin') && $comment->user_id !== $user->id) {
            abort(403);
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted.');
    }
}
