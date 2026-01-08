@extends('layouts.app')

@section('title', $user->username ?? $user->name)

@section('content')
    <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 max-w-2xl mx-auto mb-8 transition-colors duration-300">
        <div class="flex flex-col items-center text-center">
            @if($user->profile_photo_path)
                <img
                    src="{{ asset('storage/' . $user->profile_photo_path) }}"
                    class="w-32 h-32 rounded-full object-cover border-4 border-gray-50 dark:border-gray-700 shadow-sm mb-4"
                    alt="Profile photo"
                >
            @else
                <div class="w-32 h-32 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mb-4 text-gray-400 dark:text-gray-500 text-4xl font-bold">
                    {{ substr($user->username ?? $user->name, 0, 1) }}
                </div>
            @endif

            <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white mb-2">
                {{ $user->username ?? $user->name }}
            </h1>

            @if($user->birthday)
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                    Born {{ $user->birthday->format('F j, Y') }}
                </p>
            @endif

            @if($user->bio)
                <p class="text-gray-600 dark:text-gray-300 max-w-lg leading-relaxed">{{ $user->bio }}</p>
            @endif

            @auth
                @if(auth()->id() === $user->id)
                    <a class="mt-6 inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:focus:ring-gray-400 transition-colors"
                       href="{{ route('profiles.edit') }}">
                        Edit profile
                    </a>
                @endif
            @endauth
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 max-w-2xl mx-auto transition-colors duration-300">
        <div class="flex items-center gap-3 mb-6">
            <svg class="w-6 h-6 text-gray-900 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
            </svg>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Profile Wall</h2>
            <span class="ml-auto text-sm text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-full">{{ $user->profilePosts->count() }}</span>
        </div>

        @auth
            <div class="mb-8 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-gray-700 dark:to-gray-800 p-6 rounded-xl border-2 border-dashed border-purple-200 dark:border-gray-600">
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center text-white font-bold text-sm shadow-md">
                            {{ strtoupper(substr(auth()->user()->username ?? auth()->user()->name, 0, 2)) }}
                        </div>
                    </div>
                    <form method="POST" action="{{ route('profiles.posts.store', $user) }}" class="flex-1 space-y-4">
                        @csrf
                        <div>
                            <textarea name="body" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-purple-500 dark:focus:border-purple-400 focus:ring-2 focus:ring-purple-500 dark:focus:ring-purple-400 text-sm" rows="3" required maxlength="1000"
                                      placeholder="Leave a message on {{ $user->username ?? $user->name }}'s wall...">{{ old('body') }}</textarea>
                            @error('body') <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-500 dark:text-gray-400">💬 Say something nice!</span>
                            <button type="submit" class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-6 py-2.5 rounded-lg transition-all duration-200 text-sm font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                    Post Message
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @else
            <div class="mb-8 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-gray-700 dark:to-gray-800 p-6 rounded-xl border border-purple-200 dark:border-gray-600 text-center">
                <p class="text-gray-700 dark:text-gray-300 text-sm">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    Please <a href="{{ route('login') }}" class="font-bold text-purple-600 dark:text-purple-400 hover:underline">login</a> to leave a message
                </p>
            </div>
        @endauth

        <div class="space-y-4">
            @forelse($user->profilePosts as $p)
                <div class="bg-gradient-to-r from-gray-50 to-white dark:from-gray-900 dark:to-gray-800 rounded-lg p-5 hover:shadow-lg transition-all duration-200 border border-gray-200 dark:border-gray-700">
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-orange-400 to-red-500 flex items-center justify-center text-white font-bold text-sm shadow-md">
                                {{ strtoupper(substr($p->author->username ?? $p->author->name, 0, 2)) }}
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-gray-900 dark:text-white">{{ $p->author->username ?? $p->author->name }}</span>
                                    <span class="text-gray-400 dark:text-gray-500">•</span>
                                    <time class="text-xs text-gray-500 dark:text-gray-400" datetime="{{ $p->created_at->toIso8601String() }}">
                                        {{ $p->created_at->diffForHumans() }}
                                    </time>
                                    @auth
                                        @if(auth()->id() === $p->author_user_id)
                                            <span class="ml-2 text-xs bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300 px-2 py-0.5 rounded-full font-medium">You</span>
                                        @endif
                                    @endauth
                                </div>
                                
                                @auth
                                    @if(auth()->user()->can('admin') || auth()->id() === $p->author_user_id || auth()->id() === $p->profile_user_id)
                                        <form method="POST" action="{{ route('profiles.posts.destroy', $p) }}" onsubmit="return confirm('Delete this message?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 font-medium flex items-center gap-1 transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-wrap">{{ $p->body }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400 font-medium">No messages yet</p>
                    <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Be the first to leave a message!</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
