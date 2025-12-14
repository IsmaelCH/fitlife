@extends('layouts.app')

@section('title', 'Create News')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Create News</h1>

    <form method="POST" action="{{ route('news.store') }}" enctype="multipart/form-data"
          class="bg-white p-4 rounded shadow space-y-3">
        @csrf

        <div>
            <label class="block">Title *</label>
            <input class="border w-full" name="title" required value="{{ old('title') }}">
        </div>

        <div>
            <label class="block">Content *</label>
            <textarea class="border w-full" name="content" required>{{ old('content') }}</textarea>
        </div>

        <div>
            <label class="block">Published at</label>
            <input class="border" type="datetime-local" name="published_at" value="{{ old('published_at') }}">
        </div>

        <div>
            <label class="block">Image</label>
            <input type="file" name="image" accept="image/*">
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">Create</button>
    </form>
@endsection
