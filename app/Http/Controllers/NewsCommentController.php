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

        $news->comments()->create([
            'user_id' => $request->user()->id,
            'body' => $validated['body'],
        ]);

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

        return redirect()->route('news.show', $newsId)->with('success', 'Comment deleted.');
    }
}
