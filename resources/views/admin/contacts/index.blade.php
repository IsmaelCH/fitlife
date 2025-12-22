@extends('layouts.app')

@section('title', 'Admin - Contacts')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Contact messages</h1>

    <div class="bg-white rounded shadow">
        <table class="w-full">
            <thead>
            <tr class="border-b">
                <th class="text-left p-3">Date</th>
                <th class="text-left p-3">From</th>
                <th class="text-left p-3">Subject</th>
                <th class="text-left p-3">Status</th>
            </tr>
            </thead>
            <tbody>
            @foreach($contacts as $c)
                <tr class="border-b">
                    <td class="p-3">{{ $c->created_at->format('d/m/Y H:i') }}</td>
                    <td class="p-3">
                        <a class="underline" href="{{ route('admin.contacts.show', $c) }}">
                            {{ $c->name ?? 'Unknown' }} ({{ $c->email }})
                        </a>
                    </td>
                    <td class="p-3">{{ $c->subject ?? '-' }}</td>
                    <td class="p-3">
                        @if($c->replied_at) ✅ Replied @else ⏳ Open @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $contacts->links() }}</div>
@endsection
