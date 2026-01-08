@extends('layouts.app')

@section('title', $news->title)

@section('content')
    <article class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 mb-8 transition-colors duration-300">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white mb-2">{{ $news->title }}</h1>

        <div class="text-sm text-gray-500 dark:text-gray-400 mb-6 flex items-center gap-2">
            @if($news->published_at) 
                <time datetime="{{ $news->published_at->toIso8601String() }}">{{ $news->published_at->format('M d, Y \a\t H:i') }}</time>
            @endif
            <span>&middot;</span>
            <span>{{ $news->user->username ?? $news->user->name }}</span>
        </div>

        @if($news->image_path)
            <img class="mb-8 rounded-lg w-full object-cover max-h-[500px]" src="{{ asset('storage/' . $news->image_path) }}" alt="News image">
        @endif

        <div class="prose prose-gray dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line">
            {{ $news->content }}
        </div>

        @can('admin')
            <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-700 flex gap-4">
                <a class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors" href="{{ route('news.edit', $news) }}">Edit</a>

                <form method="POST" action="{{ route('news.destroy', $news) }}">
                    @csrf
                    @method('DELETE')
                    <button class="text-sm font-medium text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 transition-colors" type="submit">Delete</button>
                </form>
            </div>
        @endcan
    </article>

    <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 transition-colors duration-300">
        <div class="flex items-center gap-3 mb-6">
            <svg class="w-6 h-6 text-gray-900 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Comments</h2>
            <span class="ml-auto text-sm text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-full">{{ $news->comments->count() }}</span>
        </div>

        @auth
            <div class="mb-8 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 p-6 rounded-xl border-2 border-dashed border-gray-200 dark:border-gray-600">
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center text-white font-bold text-sm">
                            {{ strtoupper(substr(auth()->user()->username ?? auth()->user()->name, 0, 2)) }}
                        </div>
                    </div>
                    <form method="POST" action="{{ route('news.comments.store', $news) }}" class="flex-1 space-y-4">
                        @csrf
                        <div>
                            <textarea name="body" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 text-sm" rows="3" required maxlength="1000"
                                      placeholder="Share your thoughts about this article...">{{ old('body') }}</textarea>
                            @error('body') <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-500 dark:text-gray-400">✨ Be respectful and constructive</span>
                            <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-2.5 rounded-lg transition-all duration-200 text-sm font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                    Post Comment
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @else
            <div class="mb-8 bg-gradient-to-r from-blue-50 to-purple-50 dark:from-gray-700 dark:to-gray-800 p-6 rounded-xl border border-blue-200 dark:border-gray-600 text-center">
                <p class="text-gray-700 dark:text-gray-300 text-sm">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    Please <a href="{{ route('login') }}" class="font-bold text-blue-600 dark:text-blue-400 hover:underline">login</a> to join the conversation
                </p>
            </div>
        @endauth

        <div class="space-y-4">
            @forelse($news->comments as $c)
                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-5 hover:shadow-md transition-all duration-200 border border-gray-200 dark:border-gray-700">
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-400 to-teal-500 flex items-center justify-center text-white font-bold text-sm shadow-md">
                                {{ strtoupper(substr($c->user->username ?? $c->user->name, 0, 2)) }}
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="font-semibold text-gray-900 dark:text-white">{{ $c->user->username ?? $c->user->name }}</span>
                                <span class="text-gray-400 dark:text-gray-500">•</span>
                                <time class="text-xs text-gray-500 dark:text-gray-400" datetime="{{ $c->created_at->toIso8601String() }}">
                                    {{ $c->created_at->diffForHumans() }}
                                </time>
                                @auth
                                    @if(auth()->id() === $c->user_id)
                                        <span class="ml-2 text-xs bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 px-2 py-0.5 rounded-full font-medium">You</span>
                                    @endif
                                @endauth
                            </div>
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-wrap">{{ $c->body }}</p>

                            @auth
                                @if(auth()->user()->can('admin') || auth()->id() === $c->user_id)
                                    <form method="POST" action="{{ route('news.comments.destroy', $c) }}" class="mt-3" onsubmit="return confirm('Delete this comment?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 font-medium flex items-center gap-1 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400 font-medium">No comments yet</p>
                    <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Be the first to share your thoughts!</p>
                </div>
            @endforelse
        </div>
    </div>

@endsection
