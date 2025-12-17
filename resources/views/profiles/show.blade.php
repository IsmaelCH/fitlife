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
@endsection
