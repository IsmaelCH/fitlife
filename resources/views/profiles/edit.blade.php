@extends('layouts.app')

@section('title', 'Edit profile')

@section('content')
    <form
        method="POST"
        action="{{ route('profiles.update') }}"
        enctype="multipart/form-data"
        class="bg-white p-6 rounded shadow max-w-xl mx-auto space-y-4"
    >
        @csrf

        <div>
            <label>Username</label>
            <input class="border w-full"
                   name="username"
                   value="{{ old('username', $user->username) }}">
        </div>

        <div>
            <label>Birthday</label>
            <input type="date"
                   class="border w-full"
                   name="birthday"
                   value="{{ old('birthday', optional($user->birthday)->format('Y-m-d')) }}">
        </div>

        <div>
            <label>About me</label>
            <textarea class="border w-full"
                      name="bio">{{ old('bio', $user->bio) }}</textarea>
        </div>

        <div>
            <label>Profile photo</label>
            <input type="file"
                   name="profile_photo"
                   accept="image/*">
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Save
        </button>
    </form>
@endsection
