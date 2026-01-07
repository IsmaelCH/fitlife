@extends('layouts.app')

@section('title', 'FAQ')

@section('content')
    <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white mb-8">FAQ</h1>

    <div class="space-y-6">
        @forelse($categories as $cat)
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 transition-colors duration-300">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">{{ $cat->name }}</h2>

                <div class="space-y-4">
                    @forelse($cat->faqs as $faq)
                        <div class="border-b border-gray-100 dark:border-gray-700 pb-4 last:border-0 last:pb-0">
                            <p class="font-medium text-gray-900 dark:text-white mb-2">{{ $faq->question }}</p>
                            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">{{ $faq->answer }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 text-sm">No questions yet.</p>
                    @endforelse
                </div>
            </div>
        @empty
            @if(isset($apiFaq) && $apiFaq->count() > 0)
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 transition-colors duration-300">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Gym & Fitness FAQ</h2>

                    <div class="space-y-4">
                        @foreach($apiFaq as $faq)
                            <div class="border-b border-gray-100 dark:border-gray-700 pb-4 last:border-0 last:pb-0">
                                <p class="font-medium text-gray-900 dark:text-white mb-2">{{ $faq->question }}</p>
                                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">{{ $faq->answer }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400">No FAQ yet.</p>
            @endif
        @endforelse
    </div>
@endsection
