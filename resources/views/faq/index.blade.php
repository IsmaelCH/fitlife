@extends('layouts.app')

@section('title', 'FAQ')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-12">
            <h1 class="text-5xl font-extralight tracking-tight text-gray-900 dark:text-white mb-3">Frequently Asked Questions</h1>
            <p class="text-gray-500 dark:text-gray-400 font-light flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Find answers to common questions
            </p>
        </div>

        <!-- Search Bar -->
        <div class="mb-8">
            <form method="GET" action="{{ route('faq.index') }}" class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search questions and answers..." class="w-full px-5 py-3 pl-12 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white font-light focus:border-gray-900 dark:focus:border-gray-400 focus:ring-2 focus:ring-gray-900 dark:focus:ring-gray-400 transition-all">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                @if(request('search'))
                    <a href="{{ route('faq.index') }}" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </a>
                @endif
            </form>
            @if(request('search'))
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 font-light">
                    Showing results for "<span class="font-medium">{{ request('search') }}</span>"
                </p>
            @endif
        </div>
    </div>

    <div class="max-w-4xl mx-auto space-y-6">
        @forelse($categories as $cat)
            <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-2xl hover:border-gray-300 dark:hover:border-gray-600">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                        <svg class="w-6 h-6 text-gray-900 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                    </div>
                    <h2 class="text-2xl font-light text-gray-900 dark:text-white">{{ $cat->name }}</h2>
                    <span class="ml-auto text-sm text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-full">{{ $cat->faqs->count() }} Q&A</span>
                </div>

                <div class="space-y-5">
                    @forelse($cat->faqs as $faq)
                        <div class="group border-l-2 border-gray-200 dark:border-gray-700 hover:border-gray-900 dark:hover:border-white pl-6 py-3 transition-all duration-300">
                            <div class="flex items-start gap-3 mb-2">
                                <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p class="font-light text-gray-900 dark:text-white text-lg">{{ $faq->question }}</p>
                            </div>
                            <div class="flex items-start gap-3 ml-8">
                                <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p class="text-gray-600 dark:text-gray-300 leading-relaxed font-light">{{ $faq->answer }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 text-center py-8 font-light">No questions yet in this category.</p>
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
