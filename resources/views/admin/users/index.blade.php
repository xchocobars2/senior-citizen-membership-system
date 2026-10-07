@extends('layouts.app')

@section('header', 'User Management')

@section('content')
<div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <form method="GET" action="{{ route('admin.users.index') }}" class="flex gap-2">
        <input type="text" name="search" value="{{ $search }}"
               placeholder="Search users..."
               class="border-gray-300 rounded-md shadow-sm text-sm">
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700">Search</button>
    </form>
    <a href="{{ route('admin.users.create') }}"
       class="px-4 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700">
        + Add User
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($users as $user)
                <tr>
                    <td class="px-4 py-3 text-sm font-medium">{{ $user->name }}</td>
                    <td class="px-4 py-3 text-sm">{{ $user->email }}</td>
                    <td class="px-4 py-3 text-sm">
                        <span class="px-2 py-1 text-xs rounded-full
                            {{ $user->isAdmin() ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-sm space-x-2">
                        <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:underline">Edit</a>
                        @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Delete this user?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-4 py-6 text-center text-gray-500">No users found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $users->links() }}
</div>
@endsection