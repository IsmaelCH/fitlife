@extends('layouts.app')

@section('title', 'Admin - Edit FAQ')

@section('content')
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white mb-8">Edit FAQ</h1>

        <form method="POST" action="{{ route('faqs.update', $faq) }}" class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 space-y-6 transition-colors duration-300">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category *</label>
                <select class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-gray-900 dark:focus:border-gray-400 focus:ring-gray-900 dark:focus:ring-gray-400 sm:text-sm" name="faq_category_id" required>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" @selected($faq->faq_category_id === $c->id)>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Question *</label>
                <input class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-gray-900 dark:focus:border-gray-400 focus:ring-gray-900 dark:focus:ring-gray-400 sm:text-sm" name="question" required value="{{ old('question', $faq->question) }}">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Answer *</label>
                <textarea class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-gray-900 dark:focus:border-gray-400 focus:ring-gray-900 dark:focus:ring-gray-400 sm:text-sm" name="answer" rows="4" required>{{ old('answer', $faq->answer) }}</textarea>
            </div>

            <div class="pt-2">
                <button class="w-full bg-gray-900 dark:bg-gray-100 text-white dark:text-gray-900 px-4 py-2.5 rounded-md hover:bg-gray-800 dark:hover:bg-gray-200 transition-colors font-medium shadow-sm">Save Changes</button>
            </div>
        </form>
    </div>
@endsection
