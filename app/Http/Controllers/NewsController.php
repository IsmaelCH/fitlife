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
        // Public can see index + show
        // Authenticated users can create
        // Only owner or admin can update/delete
        $this->middleware('auth')->except(['index', 'show']);
        $this->middleware('can:admin')->only(['edit', 'update']);
    }

    // PUBLIC: list
    public function index(Request $request)
    {
        $query = News::with(['user', 'tags'])
            ->orderByDesc('published_at');

        // Search by title or content
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('content', 'like', '%' . $search . '%');
            });
        }

        // Filter by tag if provided
        if ($request->has('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('tags.id', $request->tag);
            });
        }

        $news = $query->paginate(10)->withQueryString();
        $tags = Tag::orderBy('name')->get();

        return view('news.index', compact('news', 'tags'));
    }

    // PUBLIC: detail
    public function show(News $news)
    {
        $news->load(['user', 'tags', 'comments.user']);
        
        // Si es una petición AJAX, devolver JSON
        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'id' => $news->id,
                'title' => $news->title,
                'content' => $news->content,
                'image_path' => $news->image_path,
                'published_at' => $news->published_at?->format('M d, Y \a\t H:i'),
                'user' => [
                    'name' => $news->user->username ?? $news->user->name,
                    'id' => $news->user->id,
                ],
                'comments_count' => $news->comments->count(),
                'comments' => $news->comments->map(function ($comment) {
                    return [
                        'id' => $comment->id,
                        'body' => $comment->body,
                        'created_at' => $comment->created_at->diffForHumans(),
                        'user' => [
                            'id' => $comment->user->id,
                            'name' => $comment->user->username ?? $comment->user->name,
                        ],
                    ];
                }),
            ]);
        }
        
        return view('news.show', compact('news'));
    }


    // ADMIN: create form
    public function create()
    {
        $tags = Tag::orderBy('name')->get();
        return view('news.create', compact('tags'));
    }

    // ADMIN: store
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
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
        
        // Sync tags
        if (isset($validated['tags'])) {
            $news->tags()->sync($validated['tags']);
        }

        return redirect()->route('news.show', $news)->with('success', 'News created.');
    }

    // ADMIN: edit form
    public function edit(News $news)
    {
        $tags = Tag::orderBy('name')->get();
        return view('news.edit', compact('news', 'tags'));
    }

    // ADMIN: update
    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
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
        
        // Sync tags
        if (isset($validated['tags'])) {
            $news->tags()->sync($validated['tags']);
        } else {
            $news->tags()->sync([]);
        }

        return redirect()->route('news.show', $news)->with('success', 'News updated.');
    }

    // USER: delete (own) or ADMIN: delete (any)
    public function destroy(News $news)
    {
        // Check if user is the owner or is admin
        if ($news->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }

        if ($news->image_path) {
            Storage::disk('public')->delete($news->image_path);
        }

        $news->delete();

        // Handle JSON requests for AJAX
        if (request()->wantsJson() || request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'News deleted.']);
        }

        return redirect()->route('news.index')->with('success', 'News deleted.');
    }
}
