@extends('layouts.app')

@section('title', 'News')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">News</h1>

        @can('admin')
            <a class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors" href="{{ route('news.create') }}">Create news</a>
        @endcan
    </div>

    <div class="space-y-6">
        @foreach($news as $item)
            <article class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 transition-all hover:shadow-md duration-300">
                <a class="text-xl font-bold text-gray-900 dark:text-white hover:text-gray-600 dark:hover:text-gray-300 transition-colors block mb-2" href="{{ route('news.show', $item) }}">
                    {{ $item->title }}
                </a>

                <div class="text-sm text-gray-500 dark:text-gray-400 mb-4 flex items-center gap-2">
                    @if($item->published_at) 
                        <time datetime="{{ $item->published_at->toIso8601String() }}">{{ $item->published_at->format('M d, Y') }}</time>
                    @endif
                    <span>&middot;</span>
                    <span>{{ $item->user->username ?? $item->user->name }}</span>
                </div>

                @if($item->image_path)
                    <img class="mb-4 rounded-lg max-h-64 w-full object-cover" src="{{ asset('storage/' . $item->image_path) }}" alt="News image">
                @endif

                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                    {{ \Illuminate\Support\Str::limit($item->content, 180) }}
                </p>
            </article>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $news->links() }}
    </div>
@endsection
