@extends('layouts.app')

@section('title', 'FitLife')

@section('content')
    <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 mb-8 transition-colors duration-300">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">FitLife</h1>
        <p class="mt-3 text-lg text-gray-600 dark:text-gray-300">
            A simple fitness community website with profiles, news, FAQ and contact.
        </p>
    </div>

    <div class="grid md:grid-cols-2 gap-8">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 transition-colors duration-300">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Latest News</h2>
                <a class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors" href="{{ route('news.index') }}">View all</a>
            </div>

            @forelse($latestNews as $n)
                <div class="border-t border-gray-100 dark:border-gray-700 py-4 first:border-t-0">
                    @if(isset($n->image_path) && $n->image_path)
                        <img class="mb-2 rounded-lg w-full h-32 object-cover" src="{{ asset('storage/' . $n->image_path) }}" alt="News image">
                    @endif
                    <a class="font-medium text-gray-900 dark:text-white hover:text-gray-600 dark:hover:text-gray-300 transition-colors block mb-1" href="{{ route('news.show', $n) }}">
                        {{ $n->title }}
                    </a>
                    <div class="text-xs text-gray-500 dark:text-gray-400">
                        @if($n->published_at) {{ $n->published_at->format('M d, Y') }} @endif
                    </div>
                </div>
            @empty
                @if(isset($apiNews) && $apiNews->count() > 0)
                    @foreach($apiNews as $n)
                        <div class="border-t border-gray-100 dark:border-gray-700 py-4 first:border-t-0">
                            @if(!empty($n->image_url))
                                <img class="mb-2 rounded-lg w-full h-32 object-cover" src="{{ $n->image_url }}" alt="News image">
                            @endif
                            <div class="font-medium text-gray-900 dark:text-white mb-1">
                                {{ $n->title }}
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $n->published_at->format('M d, Y') }} &middot; {{ $n->author }}
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="mt-3 text-gray-500 dark:text-gray-400 text-sm">No news yet.</p>
                @endif
            @endforelse
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 transition-colors duration-300">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">FAQ</h2>
                <a class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors" href="{{ route('faq.index') }}">Open FAQ</a>
            </div>

            @forelse($faqCategories as $cat)
                <div class="border-t border-gray-100 dark:border-gray-700 py-4 first:border-t-0">
                    <div class="font-medium text-gray-900 dark:text-white mb-1">{{ $cat->name }}</div>

                    @if($cat->faqs->count() > 0)
                        <div class="text-sm text-gray-600 dark:text-gray-300 line-clamp-2">{{ $cat->faqs->first()->question }}</div>
                    @else
                        <div class="text-sm text-gray-500 dark:text-gray-400">No questions yet.</div>
                    @endif
                </div>
            @empty
                @if(isset($apiFaq) && $apiFaq->count() > 0)
                    @foreach($apiFaq->take(3) as $faq)
                        <div class="border-t border-gray-100 dark:border-gray-700 py-4 first:border-t-0">
                            <div class="font-medium text-gray-900 dark:text-white mb-1">{{ $faq->category_name }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-300 line-clamp-2">{{ $faq->question }}</div>
                        </div>
                    @endforeach
                @else
                    <p class="mt-3 text-gray-500">No FAQ categories yet.</p>
                @endif
            @endforelse
        </div>
    </div>
@endsection
