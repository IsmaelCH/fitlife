@extends('layouts.app')

@section('title', $news->title)

@section('content')
    <article class="bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold">{{ $news->title }}</h1>

        <div class="text-sm text-gray-500 mt-1">
            @if($news->published_at) {{ $news->published_at->format('d/m/Y H:i') }} @endif
            — by {{ $news->user->username ?? $news->user->name }}
        </div>

        @if($news->image_path)
            <img class="mt-4 max-h-96" src="{{ asset('storage/' . $news->image_path) }}" alt="News image">
        @endif

        <div class="mt-4 whitespace-pre-line">
            {{ $news->content }}
        </div>

        @can('admin')
            <div class="mt-6 flex gap-4">
                <a class="underline" href="{{ route('news.edit', $news) }}">Edit</a>

                <form method="POST" action="{{ route('news.destroy', $news) }}">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600 underline" type="submit">Delete</button>
                </form>
            </div>
        @endcan
    </article>
@endsection
