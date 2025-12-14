@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-2">Welcome to FitLife</h1>

        <p class="mb-4">
            You are logged in as <strong>{{ auth()->user()->username ?? auth()->user()->name }}</strong>.
        </p>

        <div class="space-x-4">
            <a class="underline" href="{{ route('news.index') }}">View News</a>
            <a class="underline" href="{{ route('faq.index') }}">View FAQ</a>
            <a class="underline" href="{{ route('contact.form') }}">Contact</a>

            @can('admin')
                <a class="underline" href="{{ route('admin.users.index') }}">Admin Panel</a>
            @endcan
        </div>
    </div>
@endsection
