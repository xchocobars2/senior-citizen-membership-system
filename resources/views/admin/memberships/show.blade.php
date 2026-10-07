@extends('layouts.app')

@section('header', 'Membership Details')

@section('content')
<div class="max-w-3xl bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b bg-gray-50 flex justify-between items-center">
        <h2 class="text-lg font-semibold">{{ $membership->name }}</h2>
        <div class="space-x-2">
            <a href="{{ route('admin.memberships.edit', $membership) }}"
               class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">Edit</a>
            <a href="{{ route('admin.memberships.index') }}"
               class="px-3 py-1 bg-gray-200 text-sm rounded hover:bg-gray-300">Back</a>
        </div>
    </div>

    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
        <div>
            <p class="text-gray-500">Membership ID</p>
            <p class="font-medium">{{ $membership->membership_id ?? '—' }}</p>
        </div>
        <div>
            <p class="text-gray-500">Status</p>
            <p>
                <span class="px-2 py-1 text-xs rounded-full
                    @if($membership->membership_status === 'active') bg-green-100 text-green-800
                    @elseif($membership->membership_status === 'inactive') bg-red-100 text-red-800
                    @else bg-yellow-100 text-yellow-800 @endif">
                    {{ ucfirst($membership->membership_status) }}
                </span>
            </p>
        </div>
        <div>
            <p class="text-gray-500">Email</p>
            <p class="font-medium">{{ $membership->email }}</p>
        </div>
        <div>
            <p class="text-gray-500">Contact Number</p>
            <p class="font-medium">{{ $membership->contact_number ?? '—' }}</p>
        </div>
        <div>
            <p class="text-gray-500">Date of Birth</p>
            <p class="font-medium">{{ $membership->date_of_birth?->format('F d, Y') ?? '—' }}</p>
        </div>
        <div>
            <p class="text-gray-500">Membership Date</p>
            <p class="font-medium">{{ $membership->membership_date?->format('F d, Y') ?? '—' }}</p>
        </div>
        <div>
            <p class="text-gray-500">Expiry Date</p>
            <p class="font-medium">{{ $membership->expiry_date?->format('F d, Y') ?? '—' }}</p>
        </div>
        <div class="md:col-span-2">
            <p class="text-gray-500">Address</p>
            <p class="font-medium">{{ $membership->address ?? '—' }}</p>
        </div>
        <div class="md:col-span-2">
            <p class="text-gray-500">Notes</p>
            <p class="font-medium">{{ $membership->notes ?? '—' }}</p>
        </div>
    </div>
</div>
@endsection