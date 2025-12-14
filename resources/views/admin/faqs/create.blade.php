<?php
@extends('layouts.app')

@section('title', 'Admin - Create FAQ')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Create FAQ</h1>

    <form method="POST" action="{{ route('faqs.store') }}" class="bg-white p-4 rounded shadow space-y-3">
        @csrf

        <div>
            <label class="block">Category *</label>
            <select class="border w-full" name="faq_category_id" required>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block">Question *</label>
            <input class="border w-full" name="question" required value="{{ old('question') }}">
        </div>

        <div>
            <label class="block">Answer *</label>
            <textarea class="border w-full" name="answer" required>{{ old('answer') }}</textarea>
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">Create</button>
    </form>
@endsection
