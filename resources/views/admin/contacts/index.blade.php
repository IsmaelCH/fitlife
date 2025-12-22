@extends('layouts.app')

@section('title', 'Admin - Contacts')

@section('content')
    <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white mb-8">Contact messages</h1>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden transition-colors duration-300">
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead class="bg-gray-50 dark:bg-gray-700">
                <tr class="text-left">
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">From</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Subject</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($contacts as $c)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $c->created_at->format('M d, Y H:i') }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                            <a class="hover:text-gray-600 dark:hover:text-gray-300 transition-colors" href="{{ route('admin.contacts.show', $c) }}">
                                {{ $c->name ?? 'Unknown' }} <span class="text-gray-400 dark:text-gray-500 font-normal">({{ $c->email }})</span>
                            </a>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $c->subject ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm">
                            @if($c->replied_at)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                    Replied
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-900 dark:bg-gray-100 text-white dark:text-gray-900">
                                    Open
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $contacts->links() }}</div>
@endsection
