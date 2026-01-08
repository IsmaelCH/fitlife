@extends('layouts.app')

@section('title', 'Contact FitLife')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="text-center mb-12">
        <h1 class="text-5xl font-extralight tracking-tight text-gray-900 dark:text-white mb-3">Get in Touch</h1>
        <p class="text-gray-500 dark:text-gray-400 font-light max-w-2xl mx-auto">
            Have questions or feedback? We'd love to hear from you. Send us a message and we'll respond as soon as possible.
        </p>
    </div>

    <form method="POST" action="{{ route('contact.submit') }}"
        class="bg-white dark:bg-gray-800 p-10 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 space-y-6 transition-all duration-300 hover:shadow-2xl">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-light text-gray-700 dark:text-gray-300 mb-2 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Name
                </label>
                <input type="text" name="name" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white font-light focus:border-gray-900 dark:focus:border-gray-400 focus:ring-2 focus:ring-gray-900 dark:focus:ring-gray-400 transition-all" value="{{ old('name') }}" placeholder="Your name">
                @error('name') <p class="text-red-600 dark:text-red-400 text-sm mt-2 flex items-center gap-1"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-light text-gray-700 dark:text-gray-300 mb-2 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Email <span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white font-light focus:border-gray-900 dark:focus:border-gray-400 focus:ring-2 focus:ring-gray-900 dark:focus:ring-gray-400 transition-all" required value="{{ old('email') }}" placeholder="your@email.com">
                @error('email') <p class="text-red-600 dark:text-red-400 text-sm mt-2 flex items-center gap-1"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-light text-gray-700 dark:text-gray-300 mb-2 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                Subject
            </label>
            <input type="text" name="subject" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white font-light focus:border-gray-900 dark:focus:border-gray-400 focus:ring-2 focus:ring-gray-900 dark:focus:ring-gray-400 transition-all" value="{{ old('subject') }}" placeholder="What's this about?">
            @error('subject') <p class="text-red-600 dark:text-red-400 text-sm mt-2 flex items-center gap-1"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-light text-gray-700 dark:text-gray-300 mb-2 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                Message <span class="text-red-500">*</span>
            </label>
            <textarea name="message" rows="5" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white font-light focus:border-gray-900 dark:focus:border-gray-400 focus:ring-2 focus:ring-gray-900 dark:focus:ring-gray-400 transition-all resize-none" required placeholder="Tell us what's on your mind...">{{ old('message') }}</textarea>
            @error('message') <p class="text-red-600 dark:text-red-400 text-sm mt-2 flex items-center gap-1"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>{{ $message }}</p> @enderror
        </div>

        <div class="pt-4">
            <button type="submit" class="group w-full bg-gray-900 dark:bg-white text-white dark:text-gray-900 px-6 py-4 rounded-lg hover:bg-gray-800 dark:hover:bg-gray-100 transition-all duration-300 font-light text-base hover:shadow-lg hover:-translate-y-0.5 flex items-center justify-center gap-2">
                <svg class="w-5 h-5 transition-transform group-hover:translate-x-1 duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                Send Message
            </button>
        </div>
    </form>
</div>
@endsection