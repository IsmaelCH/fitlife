@extends('layouts.app')

@section('title', 'FAQ')

@section('content')
    <h1 class="text-2xl font-bold mb-4">FAQ</h1>

    @foreach($categories as $cat)
        <div class="bg-white p-4 rounded shadow mb-4">
            <h2 class="text-xl font-semibold">{{ $cat->name }}</h2>

            @forelse($cat->faqs as $faq)
                <div class="mt-3">
                    <p class="font-semibold">{{ $faq->question }}</p>
                    <p>{{ $faq->answer }}</p>
                </div>
            @empty
                <p class="text-gray-500 mt-2">No questions yet.</p>
            @endforelse
        </div>
    @endforeach
@endsection
