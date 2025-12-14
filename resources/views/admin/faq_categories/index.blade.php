@extends('layouts.app')

@section('title', 'Admin - FAQ Categories')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">FAQ Categories</h1>
        <a class="underline" href="{{ route('faq-categories.create') }}">Create category</a>
    </div>

    <div class="bg-white p-4 rounded shadow">
        @foreach($categories as $c)
            <div class="border-b py-2 flex justify-between">
                <div>{{ $c->name }}</div>
                <div class="flex gap-3">
                    <a class="underline" href="{{ route('faq-categories.edit', $c) }}">Edit</a>
                    <form method="POST" action="{{ route('faq-categories.destroy', $c) }}">
                        @csrf @method('DELETE')
                        <button class="text-red-600 underline" type="submit">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach

        <div class="mt-4">{{ $categories->links() }}</div>
    </div>
@endsection
