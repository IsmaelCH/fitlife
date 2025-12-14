@extends('layouts.app')

@section('title', 'Admin - Users')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Users</h1>
        <a class="underline" href="{{ route('admin.users.create') }}">Create user</a>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <table class="w-full">
            <thead>
            <tr class="text-left">
                <th class="py-2">Name</th>
                <th>Email</th>
                <th>Admin</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $u)
                <tr class="border-t">
                    <td class="py-2">{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->is_admin ? 'Yes' : 'No' }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.users.toggleAdmin', $u) }}">
                            @csrf
                            <button class="underline" type="submit">Toggle admin</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="mt-4">{{ $users->links() }}</div>
    </div>
@endsection
