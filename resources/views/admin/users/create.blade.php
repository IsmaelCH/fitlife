@extends('layouts.app')

@section('title', 'Admin - Create User')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Create User</h1>

    <form method="POST" action="{{ route('admin.users.store') }}"
          class="bg-white p-4 rounded shadow space-y-3">
        @csrf

        <div>
            <label class="block">Name *</label>
            <input class="border w-full" name="name" required value="{{ old('name') }}">
        </div>

        <div>
            <label class="block">Email *</label>
            <input class="border w-full" type="email" name="email" required value="{{ old('email') }}">
        </div>

        <div>
            <label class="block">Password *</label>
            <input class="border w-full" type="password" name="password" required minlength="8">
        </div>

        <div>
            <label class="block">Confirm password *</label>
            <input class="border w-full" type="password" name="password_confirmation" required minlength="8">
        </div>

        <div>
            <label class="inline-flex items-center gap-2">
                <input type="checkbox" name="is_admin" value="1">
                Make admin
            </label>
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">Create</button>
    </form>
@endsection
