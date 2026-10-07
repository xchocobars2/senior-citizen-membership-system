@extends('layouts.app')

@section('header', 'Membership Reports')

@section('content')
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <p class="text-sm text-gray-500">Total</p>
        <p class="text-2xl font-bold">{{ $summary['total'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <p class="text-sm text-gray-500">Active</p>
        <p class="text-2xl font-bold text-green-600">{{ $summary['active'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <p class="text-sm text-gray-500">Inactive</p>
        <p class="text-2xl font-bold text-red-600">{{ $summary['inactive'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <p class="text-sm text-gray-500">Pending</p>
        <p class="text-2xl font-bold text-yellow-600">{{ $summary['pending'] }}</p>
    </div>
</div>

<div class="mb-4">
    <form method="GET" class="flex gap-2 items-center">
        <label class="text-sm font-medium">Filter by status:</label>
        <select name="status" onchange="this.form.submit()"
                class="border-gray-300 rounded-md shadow-sm text-sm">
            <option value="all" {{ $status === 'all' ? 'selected' : '' }}>All</option>
            <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>Inactive</option>
            <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
        </select>
    </form>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Membership ID</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Membership Date</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Expiry</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($members as $member)
                <tr>
                    <td class="px-4 py-3 text-sm">{{ $member->name }}</td>
                    <td class="px-4 py-3 text-sm">{{ $member->membership_id }}</td>
                    <td class="px-4 py-3 text-sm">
                        <span class="px-2 py-1 text-xs rounded-full
                            @if($member->membership_status === 'active') bg-green-100 text-green-800
                            @elseif($member->membership_status === 'inactive') bg-red-100 text-red-800
                            @else bg-yellow-100 text-yellow-800 @endif">
                            {{ ucfirst($member->membership_status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-sm">{{ $member->membership_date?->format('M d, Y') ?? '—' }}</td>
                    <td class="px-4 py-3 text-sm">{{ $member->expiry_date?->format('M d, Y') ?? '—' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-gray-500">No records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection