@extends('layouts.app')

@section('title', 'Admin - Edit FAQ')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Edit FAQ</h1>

    <form method="POST" action="{{ route('faqs.update', $faq) }}" class="bg-white p-4 rounded shadow space-y-3">
        @csrf
        @method('PUT')

        <div>
            <label class="block">Category *</label>
            <select class="border w-full" name="faq_category_id" required>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" @selected($faq->faq_category_id === $c->id)>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block">Question *</label>
            <input class="border w-full" name="question" required value="{{ old('question', $faq->question) }}">
        </div>

        <div>
            <label class="block">Answer *</label>
            <textarea class="border w-full" name="answer" required>{{ old('answer', $faq->answer) }}</textarea>
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
    </form>
@endsection
