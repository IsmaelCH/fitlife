@extends('layouts.app')

@section('title', 'Admin - FAQ Categories')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">FAQ Categories</h1>
        <a class="bg-gray-900 dark:bg-gray-100 text-white dark:text-gray-900 px-4 py-2 rounded-md hover:bg-gray-800 dark:hover:bg-gray-200 transition-colors text-sm font-medium shadow-sm" href="{{ route('faq-categories.create') }}">Create category</a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden transition-colors duration-300">
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead class="bg-gray-50 dark:bg-gray-700">
                <tr class="text-left">
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider text-right">Actions</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($categories as $c)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">{{ $c->name }}</td>
                        <td class="px-6 py-4 text-sm text-right">
                            <div class="flex justify-end gap-3">
                                <a class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 font-medium transition-colors text-xs uppercase tracking-wide" href="{{ route('faq-categories.edit', $c) }}">Edit</a>
                                <form method="POST" action="{{ route('faq-categories.destroy', $c) }}" class="inline-block">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 font-medium transition-colors text-xs uppercase tracking-wide" type="submit">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $categories->links() }}</div>
@endsection
