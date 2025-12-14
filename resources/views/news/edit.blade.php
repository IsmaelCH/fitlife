@extends('layouts.app')

@section('title', 'Edit News')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Edit News</h1>

    <form method="POST" action="{{ route('news.update', $news) }}" enctype="multipart/form-data"
          class="bg-white p-4 rounded shadow space-y-3">
        @csrf
        @method('PUT')

        <div>
            <label class="block">Title *</label>
            <input class="border w-full" name="title" required value="{{ old('title', $news->title) }}">
        </div>

        <div>
            <label class="block">Content *</label>
            <textarea class="border w-full" name="content" required>{{ old('content', $news->content) }}</textarea>
        </div>

        <div>
            <label class="block">Published at</label>
            <input class="border" type="datetime-local" name="published_at"
                   value="{{ old('published_at', optional($news->published_at)->format('Y-m-d\TH:i')) }}">
        </div>

        <div>
            <label class="block">Replace image</label>
            <input type="file" name="image" accept="image/*">
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
    </form>
@endsection
