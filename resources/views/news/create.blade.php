@extends('layouts.app')

@section('title', 'Create news')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Create news</h1>

    <form method="POST" action="{{ route('news.store') }}" enctype="multipart/form-data"
          class="bg-white p-6 rounded shadow space-y-4">
        @csrf

        <div>
            <label class="block">Title *</label>
            <input class="border w-full" name="title" required value="{{ old('title') }}">
            @error('title') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block">Content *</label>
            <textarea class="border w-full" name="content" required rows="6">{{ old('content') }}</textarea>
            @error('content') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block">Publication date</label>
            <input class="border" type="datetime-local" name="published_at" value="{{ old('published_at') }}">
            @error('published_at') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block">Image</label>
            <input type="file" name="image" accept="image/*">
            @error('image') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-3 font-medium text-gray-700">Tags</label>
            <div class="flex flex-wrap gap-2">
                @foreach($tags as $tag)
                    <label class="inline-flex items-center px-4 py-2 rounded-full border-2 border-gray-300 hover:border-gray-900 transition-all cursor-pointer has-[:checked]:bg-gray-900 has-[:checked]:text-white has-[:checked]:border-gray-900">
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="sr-only" {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                        <span class="text-sm font-light">{{ $tag->name }}</span>
                    </label>
                @endforeach
            </div>
            @error('tags') <p class="text-red-600 text-sm mt-2">{{ $message }}</p> @enderror
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">Create</button>
    </form>
@endsection
