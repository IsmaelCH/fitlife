@extends('layouts.app')

@section('title', 'FitLife News')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Latest FitLife News</h1>

    @foreach($news as $item)
        <article class="bg-white p-4 rounded shadow mb-4">
            <h2 class="text-xl font-semibold">
                <a href="{{ route('news.show', $item) }}">{{ $item->title }}</a>
            </h2>
            <p class="text-sm text-gray-500">
                By {{ $item->user->username ?? $item->user->name }}
                @if($item->published_at)
                    - {{ $item->published_at->format('d/m/Y') }}
                @endif
            </p>
            @if($item->image_path)
                <img src="{{ asset('storage/' . $item->image_path) }}" alt="News image" class="mt-2 max-h-64">
            @endif
            <p class="mt-2">
                {{ \Illuminate\Support\Str::limit($item->content, 150) }}
            </p>
        </article>
    @endforeach

    {{ $news->links() }}
@endsection
