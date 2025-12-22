@extends('layouts.app')

@section('title', $user->username ?? $user->name)

@section('content')
    <div class="bg-white p-6 rounded shadow max-w-xl mx-auto">
        <h1 class="text-2xl font-bold">
            {{ $user->username ?? $user->name }}
        </h1>

        @if($user->profile_photo_path)
            <img
                src="{{ asset('storage/' . $user->profile_photo_path) }}"
                class="mt-4 w-32 h-32 rounded-full object-cover"
                alt="Profile photo"
            >
        @endif

        @if($user->birthday)
            <p class="mt-2">
                <strong>Birthday:</strong> {{ $user->birthday->format('d/m/Y') }}
            </p>
        @endif

        @if($user->bio)
            <p class="mt-4">{{ $user->bio }}</p>
        @endif

        @auth
            @if(auth()->id() === $user->id)
                <a class="underline mt-4 block"
                   href="{{ route('profiles.edit') }}">
                    Edit profile
                </a>
            @endif
        @endauth
    </div>
    <div class="bg-white p-6 rounded shadow max-w-xl mx-auto mt-6">
        <h2 class="text-xl font-semibold">Profile wall</h2>

        @auth
            <form method="POST" action="{{ route('profiles.posts.store', $user) }}" class="mt-4 space-y-2">
                @csrf
                <textarea name="body" class="border w-full" rows="3" required maxlength="1000"
                          placeholder="Write a message...">{{ old('body') }}</textarea>
                @error('body') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                <button class="bg-blue-600 text-white px-4 py-2 rounded">Post</button>
            </form>
        @else
            <p class="mt-3 text-gray-600">Login to post on this profile.</p>
        @endauth

        <div class="mt-6 space-y-4">
            @forelse($user->profilePosts as $p)
                <div class="border-t pt-3">
                    <div class="text-sm text-gray-500">
                        {{ $p->author->username ?? $p->author->name }}
                        • {{ $p->created_at->format('d/m/Y H:i') }}
                    </div>
                    <div class="mt-1">{{ $p->body }}</div>

                    @auth
                        @if(auth()->user()->can('admin') || auth()->id() === $p->author_user_id || auth()->id() === $p->profile_user_id)
                            <form method="POST" action="{{ route('profiles.posts.destroy', $p) }}" class="mt-2">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 underline text-sm">Delete</button>
                            </form>
                        @endif
                    @endauth
                </div>
            @empty
                <p class="mt-3 text-gray-600">No messages yet.</p>
            @endforelse
        </div>
    </div>

@endsection
