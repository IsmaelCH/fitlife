@extends('layouts.app')

@section('title', $news->title)

@section('content')
    <article class="bg-white p-4 rounded shadow">
        <h1 class="text-2xl font-bold">{{ $news->title }}</h1>
        <p class="text-sm text-gray-500">
            By {{ $news->user->username ?? $news->user->name }}
            @if($news->published_at) - {{ $news->published_at->format('d/m/Y') }} @endif
        </p>

        @if($news->image_path)
            <img class="mt-3 max-h-80" src="{{ asset('storage/' . $news->image_path) }}" alt="News image">
        @endif

        <div class="mt-4 whitespace-pre-line">{{ $news->content }}</div>
    </article>
@endsection
