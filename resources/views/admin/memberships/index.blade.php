@extends('layouts.app')

@section('header', 'Memberships')

@section('content')
<div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <form method="GET" action="{{ route('admin.memberships.index') }}" class="flex gap-2">
        <input type="text" name="search" value="{{ $search }}"
               placeholder="Search by name, email, ID..."
               class="border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700">
            Search
        </button>
        @if($search)
            <a href="{{ route('admin.memberships.index') }}" class="px-4 py-2 bg-gray-200 text-sm rounded-md hover:bg-gray-300">
                Clear
            </a>
        @endif
    </form>
    <a href="{{ route('admin.memberships.create') }}"
       class="px-4 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700">
        + Add Member
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Membership ID</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contact</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($members as $member)
                <tr>
                    <td class="px-4 py-3 text-sm font-medium">{{ $member->name }}</td>
                    <td class="px-4 py-3 text-sm">{{ $member->membership_id }}</td>
                    <td class="px-4 py-3 text-sm">{{ $member->contact_number ?? '—' }}</td>
                    <td class="px-4 py-3 text-sm">
                        <span class="px-2 py-1 text-xs rounded-full
                            @if($member->membership_status === 'active') bg-green-100 text-green-800
                            @elseif($member->membership_status === 'inactive') bg-red-100 text-red-800
                            @else bg-yellow-100 text-yellow-800 @endif">
                            {{ ucfirst($member->membership_status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-sm space-x-2">
                        <a href="{{ route('admin.memberships.show', $member) }}" class="text-indigo-600 hover:underline">View</a>
                        <a href="{{ route('admin.memberships.edit', $member) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('admin.memberships.destroy', $member) }}" method="POST" class="inline"
                              onsubmit="return confirm('Delete this membership?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-gray-500">No memberships found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $members->links() }}
</div>
@endsection