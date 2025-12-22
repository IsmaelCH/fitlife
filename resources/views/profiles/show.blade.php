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
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Profile wall</h2>

        @auth
            <form method="POST" action="{{ route('profiles.posts.store', $user) }}" class="mb-8 space-y-4">
                @csrf
                <div>
                    <textarea name="body" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-gray-900 dark:focus:border-gray-400 focus:ring-gray-900 dark:focus:ring-gray-400 sm:text-sm" rows="3" required maxlength="1000"
                              placeholder="Write a message...">{{ old('body') }}</textarea>
                    @error('body') <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <button class="bg-gray-900 dark:bg-gray-100 text-white dark:text-gray-900 px-4 py-2 rounded-md hover:bg-gray-800 dark:hover:bg-gray-200 transition-colors text-sm font-medium">Post</button>
            </form>
        @else
            <p class="mb-8 text-gray-600 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg text-sm">Please <a href="{{ route('login') }}" class="font-medium text-gray-900 dark:text-white underline">login</a> to post on this profile.</p>
        @endauth

        <div class="space-y-6">
            @forelse($user->profilePosts as $p)
                <div class="border-t border-gray-100 dark:border-gray-700 pt-4 first:border-t-0 first:pt-0">
                    <div class="flex justify-between items-start">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="font-medium text-gray-900 dark:text-white">{{ $p->author->username ?? $p->author->name }}</span>
                            <span class="text-gray-300 dark:text-gray-600">&middot;</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $p->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        
                        @auth
                            @if(auth()->user()->can('admin') || auth()->id() === $p->author_user_id || auth()->id() === $p->profile_user_id)
                                <form method="POST" action="{{ route('profiles.posts.destroy', $p) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-xs text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 transition-colors font-medium">Delete</button>
                                </form>
                            @endif
                        @endauth
                    </div>
                    <div class="text-gray-600 dark:text-gray-300 leading-relaxed">{{ $p->body }}</div>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400 text-sm">No messages yet.</p>
            @endforelse
        </div>
    </div>
@endsection
