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
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Comments</h2>

        @auth
            <form method="POST" action="{{ route('news.comments.store', $news) }}" class="mb-8 space-y-4">
                @csrf
                <div>
                    <textarea name="body" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-gray-900 dark:focus:border-gray-400 focus:ring-gray-900 dark:focus:ring-gray-400 sm:text-sm" rows="3" required maxlength="1000"
                              placeholder="Write your comment...">{{ old('body') }}</textarea>
                    @error('body') <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <button class="bg-gray-900 dark:bg-gray-100 text-white dark:text-gray-900 px-4 py-2 rounded-md hover:bg-gray-800 dark:hover:bg-gray-200 transition-colors text-sm font-medium">Post comment</button>
            </form>
        @else
            <p class="mb-8 text-gray-600 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg text-sm">Please <a href="{{ route('login') }}" class="font-medium text-gray-900 dark:text-white underline">login</a> to post a comment.</p>
        @endauth

        <div class="space-y-6">
            @forelse($news->comments as $c)
                <div class="border-t pt-3">
                    <div class="text-sm text-gray-500">
                        {{ $c->user->username ?? $c->user->name }}
                        • {{ $c->created_at->format('d/m/Y H:i') }}
                    </div>
                    <div class="mt-1">{{ $c->body }}</div>

                    @auth
                        @if(auth()->user()->can('admin') || auth()->id() === $c->user_id)
                            <form method="POST" action="{{ route('news.comments.destroy', $c) }}" class="mt-2">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 underline text-sm">Delete</button>
                            </form>
                        @endif
                    @endauth
                </div>
            @empty
                <p class="mt-3 text-gray-600">No comments yet.</p>
            @endforelse
        </div>
    </div>

@endsection
