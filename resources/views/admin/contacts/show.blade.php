@extends('layouts.app')

@section('title', 'Admin - Contact detail')

@section('content')
    <a class="underline" href="{{ route('admin.contacts.index') }}">← Back</a>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 mt-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-6 rounded shadow mt-4">
        <h1 class="text-2xl font-bold">Contact detail</h1>

        <p class="mt-2"><strong>Name:</strong> {{ $contact->name ?? 'Unknown' }}</p>
        <p><strong>Email:</strong> {{ $contact->email }}</p>
        <p><strong>Subject:</strong> {{ $contact->subject ?? '-' }}</p>

        <div class="mt-4">
            <strong>Message:</strong>
            <div class="whitespace-pre-line mt-2">{{ $contact->message }}</div>
        </div>
    </div>

    <div class="bg-white p-6 rounded shadow mt-6">
        <h2 class="text-xl font-semibold">Reply</h2>

        @if($contact->replied_at)
            <p class="mt-2 text-green-700">
                ✅ Replied at {{ $contact->replied_at->format('d/m/Y H:i') }}
                @if($contact->repliedBy)
                    by {{ $contact->repliedBy->username ?? $contact->repliedBy->name }}
                @endif
            </p>

            @if($contact->reply_message)
                <div class="mt-3 whitespace-pre-line">{{ $contact->reply_message }}</div>
            @endif
        @else
            <p class="mt-2 text-gray-600">⏳ Not replied yet.</p>
        @endif

        <form method="POST" action="{{ route('admin.contacts.reply', $contact) }}" class="mt-4 space-y-2">
            @csrf
            <textarea name="reply_message" class="border w-full" rows="5" required maxlength="3000"
                      placeholder="Write your reply...">{{ old('reply_message') }}</textarea>
            @error('reply_message') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            <button class="bg-blue-600 text-white px-4 py-2 rounded">Send reply</button>
        </form>
    </div>
@endsection
