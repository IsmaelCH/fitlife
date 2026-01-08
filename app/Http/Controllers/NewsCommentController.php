<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsComment;
use Illuminate\Http\Request;

class NewsCommentController extends Controller
{
    public function store(Request $request, News $news)
    {
        $validated = $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $comment = $news->comments()->create([
            'user_id' => $request->user()->id,
            'body' => $validated['body'],
        ]);

        // Return JSON for AJAX requests
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'comment' => [
                    'id' => $comment->id,
                    'body' => $comment->body,
                    'created_at' => $comment->created_at->diffForHumans(),
                    'user' => [
                        'id' => $comment->user->id,
                        'name' => $comment->user->username ?? $comment->user->name,
                    ],
                ],
            ]);
        }

        return redirect()->route('news.show', $news)->with('success', 'Comment added.');
    }

    public function destroy(NewsComment $comment)
    {
        $user = auth()->user();

        // Admin or owner can delete
        if (! $user->can('admin') && $comment->user_id !== $user->id) {
            abort(403);
        }

        $newsId = $comment->news_id;
        $comment->delete();

        // Return JSON for AJAX requests
        if (request()->wantsJson() || request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('news.show', $newsId)->with('success', 'Comment deleted.');
    }
}
