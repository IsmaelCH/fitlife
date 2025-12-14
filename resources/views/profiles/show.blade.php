@extends('layouts.app')

@section('title', $user->username ?? $user->name)

@section('content')
    <div class="bg-white p-4 rounded shadow">
        <div class="flex items-center space-x-4">
            @if($user->profile_photo_path)
                <img src="{{ asset('storage/' . $user->profile_photo_path) }}"
                     class="w-24 h-24 rounded-full object-cover" alt="Profile photo">
            @endif
            <div>
                <h1 class="text-2xl font-bold">{{ $user->username ?? $user->name }}</h1>
                @if($user->birthday)
                    <p>Birthday: {{ $user->birthday->format('d/m/Y') }}</p>
                @endif
            </div>
        </div>

        @if($user->bio)
            <div class="mt-4">
                <h2 class="text-xl font-semibold">About me</h2>
                <p>{{ $user->bio }}</p>
            </div>
        @endif
    </div>
@endsection
