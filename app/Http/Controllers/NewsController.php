<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Tag;
use App\Services\FitnessApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function __construct()
    {
        // Public can see index + show
        // Admin only for create/edit/delete
        $this->middleware('auth')->except(['index', 'show']);
        $this->middleware('can:admin')->except(['index', 'show']);
    }

    // PUBLIC: list
    public function index(Request $request)
    {
        $query = News::with(['user', 'tags'])
            ->orderByDesc('published_at');

        // Filter by tag if provided
        if ($request->has('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('tags.id', $request->tag);
            });
        }

        $news = $query->paginate(10);
        $tags = Tag::orderBy('name')->get();

        // Si no hay noticias, obtener datos de la API de fitness
        $apiNews = collect();
        if ($news->count() === 0) {
            $fitnessApi = app(FitnessApiService::class);
            $exercises = $fitnessApi->getExercises(10);
            
            $apiNews = $exercises->map(function ($exercise, $index) {
                return (object) [
                    'id' => 'api_' . $exercise['id'],
                    'title' => $exercise['name'],
                    'content' => $exercise['description'],
                    'image_url' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=800&h=600&fit=crop',
                    'published_at' => now()->subDays(rand(1, 30)),
                    'author' => 'Wger Fitness API',
                ];
            });
        }

        return view('news.index', compact('news', 'apiNews', 'tags'));
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
