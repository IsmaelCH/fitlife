@extends('layouts.app')

@section('title', 'News')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">News</h1>

        @can('admin')
            <a class="underline" href="{{ route('news.create') }}">Create news</a>
        @endcan
    </div>

    @foreach($news as $item)
        <div class="bg-white p-4 rounded shadow mb-4">
            <a class="text-xl font-semibold underline" href="{{ route('news.show', $item) }}">
                {{ $item->title }}
            </a>

            <div class="text-sm text-gray-500 mt-1">
                @if($item->published_at) {{ $item->published_at->format('d/m/Y H:i') }} @endif
                — by {{ $item->user->username ?? $item->user->name }}
            </div>

            @if($item->image_path)
                <img class="mt-3 max-h-56" src="{{ asset('storage/' . $item->image_path) }}" alt="News image">
            @endif

            <p class="mt-3">
                {{ \Illuminate\Support\Str::limit($item->content, 180) }}
            </p>
        </div>
    @endforeach

    <div class="mt-4">
        {{ $news->links() }}
    </div>
@endsection
