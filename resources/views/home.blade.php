@extends('layouts.app')

@section('title', 'FitLife')

@section('content')
    <div class="bg-white p-6 rounded shadow mb-6">
        <h1 class="text-2xl font-bold">FitLife</h1>
        <p class="mt-2">
            A simple fitness community website with profiles, news, FAQ and contact.
        </p>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-white p-4 rounded shadow">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold">Latest News</h2>
                <a class="underline" href="{{ route('news.index') }}">View all</a>
            </div>

            @forelse($latestNews as $n)
                <div class="border-t py-3">
                    <a class="font-semibold underline" href="{{ route('news.show', $n) }}">
                        {{ $n->title }}
                    </a>
                    <div class="text-sm text-gray-500">
                        @if($n->published_at) {{ $n->published_at->format('d/m/Y H:i') }} @endif
                    </div>
                </div>
            @empty
                <p class="mt-3 text-gray-500">No news yet.</p>
            @endforelse
        </div>

        <div class="bg-white p-4 rounded shadow">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold">FAQ</h2>
                <a class="underline" href="{{ route('faq.index') }}">Open FAQ</a>
            </div>

            @forelse($faqCategories as $cat)
                <div class="border-t py-3">
                    <div class="font-semibold">{{ $cat->name }}</div>

                    @if($cat->faqs->count() > 0)
                        <div class="text-sm text-gray-700">{{ $cat->faqs->first()->question }}</div>
                    @else
                        <div class="text-sm text-gray-500">No questions yet.</div>
                    @endif
                </div>
            @empty
                <p class="mt-3 text-gray-500">No FAQ categories yet.</p>
            @endforelse
        </div>
    </div>
@endsection
