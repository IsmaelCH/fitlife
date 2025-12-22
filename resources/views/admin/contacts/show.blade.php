@extends('layouts.app')

@section('title', 'Admin - Contact detail')

@section('content')
    <div class="max-w-3xl mx-auto">
        <a class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 transition-colors mb-6 inline-block" href="{{ route('admin.contacts.index') }}">← Back to messages</a>

        @if(session('success'))
            <div class="bg-white dark:bg-gray-800 border border-green-100 dark:border-green-900 text-green-700 dark:text-green-400 px-4 py-3 mb-6 rounded-lg shadow-sm text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 mb-8 transition-colors duration-300">
            <div class="flex justify-between items-start mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Contact detail</h1>
                @if($contact->replied_at)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                        Replied
                    </span>
                @else
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-900 dark:bg-gray-100 text-white dark:text-gray-900">
                        Open
                    </span>
                @endif
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 mb-8">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">From</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $contact->name ?? 'Unknown' }}</dd>
                    <dd class="text-sm text-gray-500 dark:text-gray-400">{{ $contact->email }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Subject</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $contact->subject ?? '-' }}</dd>
                </div>
            </div>

            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Message</dt>
                <dd class="text-sm text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg whitespace-pre-line leading-relaxed border border-gray-100 dark:border-gray-600">{{ $contact->message }}</dd>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 transition-colors duration-300">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Reply</h2>

            @if($contact->replied_at)
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-100 dark:border-gray-600 mb-6">
                    <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-2">
                        <span class="font-medium text-gray-900 dark:text-white">Replied by {{ $contact->repliedBy->username ?? $contact->repliedBy->name }}</span>
                        <span>&middot;</span>
                        <span>{{ $contact->replied_at->format('M d, Y H:i') }}</span>
                    </div>
                    @if($contact->reply_message)
                        <div class="text-gray-700 dark:text-gray-300 whitespace-pre-line text-sm leading-relaxed">{{ $contact->reply_message }}</div>
                    @endif
                </div>
            @else
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">This message has not been replied to yet.</p>
            @endif

            <form method="POST" action="{{ route('admin.contacts.reply', $contact) }}" class="space-y-4">
                @csrf
                <div>
                    <textarea name="reply_message" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-gray-900 dark:focus:border-gray-400 focus:ring-gray-900 dark:focus:ring-gray-400 sm:text-sm" rows="5" required maxlength="3000"
                              placeholder="Write your reply...">{{ old('reply_message') }}</textarea>
                    @error('reply_message') <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="flex justify-end">
                    <button class="bg-gray-900 dark:bg-gray-100 text-white dark:text-gray-900 px-4 py-2 rounded-md hover:bg-gray-800 dark:hover:bg-gray-200 transition-colors text-sm font-medium shadow-sm">Send reply</button>
                </div>
            </form>
        </div>
    </div>
@endsection
