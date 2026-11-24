@extends('layouts.app')

@section('header', 'Admin Dashboard')

@section('content')

{{-- Welcome --}}
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Welcome, Admin!</h2>
    <p class="text-gray-500 text-sm">Overview of the Senior Citizen Membership System</p>
</div>

{{-- ==================== WEATHER CARD ==================== --}}
<div class="mb-8">
    {{-- Search --}}
    <form method="GET" action="{{ route('admin.dashboard') }}" class="mb-4 flex gap-2 max-w-md">
        <input type="text" name="city" value="{{ $city ?? '' }}"
               placeholder="Search city (e.g. Manila, Tokyo, Cebu)..."
               class="flex-1 border-gray-300 rounded-lg shadow-sm text-sm px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
        <button type="submit" class="px-5 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
            Search
        </button>
    </form>

    @if($weather['success'])
        <div class="bg-gradient-to-r from-blue-600 to-cyan-500 rounded-xl shadow-lg p-6 text-white">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <p class="text-sm opacity-90 uppercase tracking-wide">Current Weather</p>
                    <h2 class="text-2xl font-bold mt-1">
                        {{ $weather['city'] }}
                        @if(!empty($weather['country']))
                            <span class="text-lg font-normal opacity-90">, {{ $weather['country'] }}</span>
                        @endif
                    </h2>
                    <p class="text-lg mt-1 capitalize">{{ $weather['description'] }}</p>
                </div>

                <div class="flex items-center gap-4">
                    @if($weather['icon'])
                        <img src="https://openweathermap.org/img/wn/{{ $weather['icon'] }}@2x.png"
                             alt="Weather icon" class="w-16 h-16">
                    @endif
                    <div class="text-right">
                        <p class="text-4xl font-bold">{{ $weather['temperature'] }}°C</p>
                    </div>
                </div>
            </div>

            <div class="mt-5 grid grid-cols-2 sm:grid-cols-3 gap-4 text-sm">
                <div class="bg-white/20 rounded-lg p-3 backdrop-blur-sm">
                    <p class="opacity-90">Humidity</p>
                    <p class="text-lg font-semibold">{{ $weather['humidity'] }}%</p>
                </div>
                <div class="bg-white/20 rounded-lg p-3 backdrop-blur-sm">
                    <p class="opacity-90">Wind Speed</p>
                    <p class="text-lg font-semibold">{{ $weather['wind_speed'] }} m/s</p>
                </div>
                <div class="bg-white/20 rounded-lg p-3 backdrop-blur-sm col-span-2 sm:col-span-1">
                    <p class="opacity-90">Condition</p>
                    <p class="text-lg font-semibold capitalize">{{ $weather['description'] }}</p>
                </div>
            </div>
        </div>
    @else
        <div class="bg-gray-100 border border-gray-300 rounded-xl p-5 text-gray-600">
            <p class="font-medium">Weather Information</p>
            <p class="text-sm mt-1">{{ $weather['message'] }}</p>
        </div>
    @endif
</div>

{{-- ==================== STATS CARDS ==================== --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-xl shadow p-5 border-l-4 border-indigo-500">
        <p class="text-sm text-gray-500 font-medium">Total Members</p>
        <p class="text-3xl font-bold text-indigo-600 mt-1">{{ $stats['total_members'] }}</p>
    </div>
    <div class="bg-white rounded-xl shadow p-5 border-l-4 border-green-500">
        <p class="text-sm text-gray-500 font-medium">Active</p>
        <p class="text-3xl font-bold text-green-600 mt-1">{{ $stats['active_members'] }}</p>
    </div>
    <div class="bg-white rounded-xl shadow p-5 border-l-4 border-red-500">
        <p class="text-sm text-gray-500 font-medium">Inactive</p>
        <p class="text-3xl font-bold text-red-600 mt-1">{{ $stats['inactive_members'] }}</p>
    </div>
    <div class="bg-white rounded-xl shadow p-5 border-l-4 border-yellow-500">
        <p class="text-sm text-gray-500 font-medium">Pending</p>
        <p class="text-3xl font-bold text-yellow-600 mt-1">{{ $stats['pending_members'] }}</p>
    </div>
</div>

{{-- ==================== RECENT MEMBERS ==================== --}}
<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="px-6 py-4 border-b bg-gray-50">
        <h2 class="text-lg font-semibold text-gray-800">Recent Members</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Membership ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($recentMembers as $member)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $member->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $member->membership_id ?? '—' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($member->membership_status === 'active') bg-green-100 text-green-800
                                @elseif($member->membership_status === 'inactive') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst($member->membership_status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $member->created_at->format('M d, Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                            No members yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection