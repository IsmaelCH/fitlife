<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function __construct()
    {
        // Public can see index + show
        // Only admins can create/edit/delete
        $this->middleware('auth')->except(['index', 'show']);
        $this->middleware('can:admin')->except(['index', 'show']);
    }

    // PUBLIC: list
    public function index()
    {
        $news = News::with('user')
            ->orderByDesc('published_at')
            ->paginate(10);

        return view('news.index', compact('news'));
    }

    // PUBLIC: detail
    public function show(News $news)
    {
        $news->load('user');
        return view('news.show', compact('news'));
    }

    // ADMIN: form create
    public function create()
    {
        return view('news.create');
    }

    // ADMIN: store
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = [
            'user_id' => $request->user()->id,
            'title' => $validated['title'],
            'content' => $validated['content'],
            'published_at' => $validated['published_at'] ?? now(),
        ];

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('news', 'public');
        }

        $news = News::create($data);

        return redirect()->route('news.show', $news)->with('success', 'News created.');
    }

    // ADMIN: edit form
    public function edit(News $news)
    {
        return view('news.edit', compact('news'));
    }

    // ADMIN: update
    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = [
            'title' => $validated['title'],
            'content' => $validated['content'],
            'published_at' => $validated['published_at'] ?? $news->published_at,
        ];

        if ($request->hasFile('image')) {
            // delete old image
            if ($news->image_path) {
                Storage::disk('public')->delete($news->image_path);
            }
            $data['image_path'] = $request->file('image')->store('news', 'public');
        }

        $news->update($data);

        return redirect()->route('news.show', $news)->with('success', 'News updated.');
    }

    // ADMIN: delete
    public function destroy(News $news)
    {
        if ($news->image_path) {
            Storage::disk('public')->delete($news->image_path);
        }

        $news->delete();

        return redirect()->route('news.index')->with('success', 'News deleted.');
    }
}
