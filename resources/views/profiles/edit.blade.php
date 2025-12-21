@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Edit Profile</h1>

    <form method="POST" action="{{ route('profiles.update') }}" enctype="multipart/form-data"
          class="bg-white p-4 rounded shadow space-y-3">
        @csrf

        <div>
            <label class="block">Username</label>
            <input class="border w-full" name="username" value="{{ old('username', $user->username) }}">
            @error('username') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block">Birthday</label>
            <input class="border w-full" type="date" name="birthday" value="{{ old('birthday', optional($user->birthday)->format('Y-m-d')) }}">
            @error('birthday') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block">Bio</label>
            <textarea class="border w-full" name="bio">{{ old('bio', $user->bio) }}</textarea>
            @error('bio') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block">Profile photo</label>
            <input type="file" name="profile_photo" accept="image/*">
            @error('profile_photo') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block">New password (optional)</label>
            <input class="border w-full" type="password" name="password" minlength="8">
            @error('password') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block">Confirm new password</label>
            <input class="border w-full" type="password" name="password_confirmation" minlength="8">
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
    </form>
@endsection
