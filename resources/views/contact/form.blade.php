@extends('layouts.app')

@section('title', 'Contact FitLife')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Contact us</h1>

    <form method="POST" action="{{ route('contact.submit') }}"
          class="bg-white p-4 rounded shadow space-y-3">
        @csrf

        <div>
            <label class="block">Name</label>
            <input type="text" name="name" class="border w-full" value="{{ old('name') }}">
            @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block">Email *</label>
            <input type="email" name="email" class="border w-full" required value="{{ old('email') }}">
            @error('email') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block">Subject</label>
            <input type="text" name="subject" class="border w-full" value="{{ old('subject') }}">
            @error('subject') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block">Message *</label>
            <textarea name="message" class="border w-full" required>{{ old('message') }}</textarea>
            @error('message') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
            Send
        </button>
    </form>
@endsection
