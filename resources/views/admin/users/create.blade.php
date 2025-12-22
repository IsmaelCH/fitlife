@extends('layouts.app')

@section('title', 'Admin - Create User')

@section('content')
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white mb-8">Create User</h1>

        <form method="POST" action="{{ route('admin.users.store') }}"
              class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 space-y-6 transition-colors duration-300">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name *</label>
                <input class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-gray-900 dark:focus:border-gray-400 focus:ring-gray-900 dark:focus:ring-gray-400 sm:text-sm" name="name" required value="{{ old('name') }}">
                @error('name') <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email *</label>
                <input class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-gray-900 dark:focus:border-gray-400 focus:ring-gray-900 dark:focus:ring-gray-400 sm:text-sm" type="email" name="email" required value="{{ old('email') }}">
                @error('email') <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password *</label>
                <input class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-gray-900 dark:focus:border-gray-400 focus:ring-gray-900 dark:focus:ring-gray-400 sm:text-sm" type="password" name="password" required minlength="8">
                @error('password') <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirm password *</label>
                <input class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-gray-900 dark:focus:border-gray-400 focus:ring-gray-900 dark:focus:ring-gray-400 sm:text-sm" type="password" name="password_confirmation" required minlength="8">
            </div>

            <div class="flex items-center">
                <input id="is_admin" type="checkbox" name="is_admin" value="1" class="h-4 w-4 text-gray-900 dark:text-gray-100 focus:ring-gray-900 dark:focus:ring-gray-400 border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded">
                <label for="is_admin" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                    Grant Admin Privileges
                </label>
            </div>

            <div class="pt-2">
                <button class="w-full bg-gray-900 dark:bg-gray-100 text-white dark:text-gray-900 px-4 py-2.5 rounded-md hover:bg-gray-800 dark:hover:bg-gray-200 transition-colors font-medium shadow-sm">Create User</button>
            </div>
        </form>
    </div>
@endsection
