@extends('layouts.app')

@section('title', 'Contact')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Contact</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('contact.submit') }}"
          class="bg-white p-6 rounded shadow space-y-4">
        @csrf

        <div>
            <label class="block">Name *</label>
            <input class="border w-full" name="name" value="{{ old('name') }}" required>
            @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block">Email *</label>
            <input class="border w-full" name="email" type="email" value="{{ old('email') }}" required>
            @error('email') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block">Message *</label>
            <textarea class="border w-full" name="message" rows="5" required>{{ old('message') }}</textarea>
            @error('message') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Send message
        </button>
    </form>
@endsection
