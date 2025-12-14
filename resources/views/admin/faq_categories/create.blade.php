@extends('layouts.app')

@section('title', 'Admin - Create Category')

@section('content')
<h1 class="text-2xl font-bold mb-4">Create FAQ Category</h1>

<form method="POST" action="{{ route('faq-categories.store') }}" class="bg-white p-4 rounded shadow space-y-3">
    @csrf
    <div>
        <label class="block">Name *</label>
        <input class="border w-full" name="name" required value="{{ old('name') }}">
    </div>
    <button class="bg-blue-600 text-white px-4 py-2 rounded">Create</button>
</form>
@endsection
