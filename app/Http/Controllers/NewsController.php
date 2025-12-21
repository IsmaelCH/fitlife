<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->middleware('can:admin')->except(['index', 'show']);
    }

    public function index()
    {
        $news = News::with('user')->latest('published_at')->paginate(10);
        return view('news.index', compact('news'));
    }

    public function create()
    {
        $tags = Tag::all();
        return view('news.create', compact('tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'published_at' => 'nullable|date',
            'tags' => 'array',
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

        if (!empty($validated['tags'])) {
            $news->tags()->sync($validated['tags']);
        }

        return redirect()->route('news.show', $news)->with('success', 'News created.');
    }

    public function show(News $news)
    {
        $news->load('user', 'tags');
        return view('news.show', compact('news'));
    }

    public function edit(News $news)
    {
        $tags = Tag::all();
        $news->load('tags');
        return view('news.edit', compact('news', 'tags'));
    }

    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'published_at' => 'nullable|date',
            'tags' => 'array',
        ]);

        $data = [
            'title' => $validated['title'],
            'content' => $validated['content'],
            'published_at' => $validated['published_at'] ?? $news->published_at,
        ];

        if ($request->hasFile('image')) {
            if ($news->image_path) {
                Storage::disk('public')->delete($news->image_path);
            }
            $data['image_path'] = $request->file('image')->store('news', 'public');
        }

        $news->update($data);
        $news->tags()->sync($validated['tags'] ?? []);

        return redirect()->route('news.show', $news)->with('success', 'News updated.');
    }

    public function destroy(News $news)
    {
        if ($news->image_path) {
            Storage::disk('public')->delete($news->image_path);
        }
        $news->tags()->detach();
        $news->delete();

        return redirect()->route('news.index')->with('success', 'News deleted.');
    }
}
