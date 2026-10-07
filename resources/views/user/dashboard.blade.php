@extends('layouts.app')

@section('header', 'My Membership Dashboard')

@section('content')
<div class="max-w-3xl space-y-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-1">Welcome, {{ $user->name }}!</h2>
        <p class="text-gray-600 text-sm">Here is your membership information.</p>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium">Membership Status</h3>
            <span class="px-3 py-1 text-sm rounded-full font-medium
                @if($user->membership_status === 'active') bg-green-100 text-green-800
                @elseif($user->membership_status === 'inactive') bg-red-100 text-red-800
                @else bg-yellow-100 text-yellow-800 @endif">
                {{ ucfirst($user->membership_status ?? 'Pending') }}
            </span>
        </div>

        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
            <div>
                <dt class="text-gray-500">Membership ID</dt>
                <dd class="font-medium">{{ $user->membership_id ?? 'Not assigned' }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">Email</dt>
                <dd class="font-medium">{{ $user->email }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">Contact Number</dt>
                <dd class="font-medium">{{ $user->contact_number ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">Date of Birth</dt>
                <dd class="font-medium">{{ $user->date_of_birth?->format('F d, Y') ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">Membership Date</dt>
                <dd class="font-medium">{{ $user->membership_date?->format('F d, Y') ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">Expiry Date</dt>
                <dd class="font-medium">{{ $user->expiry_date?->format('F d, Y') ?? '—' }}</dd>
            </div>
            <div class="sm:col-span-2">
                <dt class="text-gray-500">Address</dt>
                <dd class="font-medium">{{ $user->address ?? '—' }}</dd>
            </div>
        </dl>
    </div>

    <div>
        <a href="{{ route('user.profile.edit') }}"
           class="inline-block px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700">
            Edit My Profile
        </a>
    </div>
</div>
@endsection