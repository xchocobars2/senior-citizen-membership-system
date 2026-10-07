@extends('layouts.app')

@section('header', 'Admin Dashboard')

@section('content')

{{-- ═══════════════ WEATHER CARD + SEARCH ═══════════════ --}}
<div class="mb-6">

    {{-- Search Bar --}}
    <form method="GET" action="{{ route('admin.dashboard') }}" class="mb-4">
        <div class="flex gap-2 max-w-lg">
            <input type="text"
                   name="city"
                   value="{{ old('city', $city ?? '') }}"
                   placeholder="Search any city in the world (e.g. Tokyo, London, Cebu, New York)..."
                   class="flex-1 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm px-4 py-2.5"
                   required>
            <button type="submit"
                    class="px-5 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                Search
            </button>
        </div>
    </form>

    {{-- Weather Result --}}
    @if($weather['success'])
        <div class="bg-gradient-to-r from-blue-500 to-cyan-500 rounded-xl shadow-lg p-6 text-white">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <p class="text-sm opacity-80 uppercase tracking-wide">Current Weather</p>
                    <h2 class="text-2xl font-bold mt-1">
                        {{ $weather['city'] }}
                        @if(!empty($weather['country']))
                            <span class="text-lg font-normal opacity-90">, {{ $weather['country'] }}</span>
                        @endif
                    </h2>
                    <p class="text-lg mt-1 capitalize">{{ $weather['description'] }}</p>
                </div>

                <div class="flex items-center gap-6">
                    @if($weather['icon'])
                        <img src="https://openweathermap.org/img/wn/{{ $weather['icon'] }}@2x.png"
                             alt="Weather icon"
                             class="w-16 h-16">
                    @endif
                    <div class="text-right">
                        <p class="text-4xl font-bold">{{ $weather['temperature'] }}°C</p>
                    </div>
                </div>
            </div>

            <div class="mt-5 grid grid-cols-2 sm:grid-cols-3 gap-4 text-sm">
                <div class="bg-white/20 rounded-lg p-3">
                    <p class="opacity-80">Humidity</p>
                    <p class="text-lg font-semibold">{{ $weather['humidity'] }}%</p>
                </div>
                <div class="bg-white/20 rounded-lg p-3">
                    <p class="opacity-80">Wind Speed</p>
                    <p class="text-lg font-semibold">{{ $weather['wind_speed'] }} m/s</p>
                </div>
                <div class="bg-white/20 rounded-lg p-3 col-span-2 sm:col-span-1">
                    <p class="opacity-80">Condition</p>
                    <p class="text-lg font-semibold capitalize">{{ $weather['description'] }}</p>
                </div>
            </div>
        </div>
    @else
        {{-- Fallback when API fails or city not found --}}
        <div class="bg-gray-100 border border-gray-300 rounded-xl p-5 text-gray-600">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                </svg>
                <div>
                    <p class="font-medium">Weather Information</p>
                    <p class="text-sm">{{ $weather['message'] }}</p>
                </div>
            </div>
        </div>
    @endif
</div>


<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-lg shadow p-5">
        <p class="text-sm text-gray-500">Total Members</p>
        <p class="text-3xl font-bold text-indigo-600">{{ $stats['total_members'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-5">
        <p class="text-sm text-gray-500">Active</p>
        <p class="text-3xl font-bold text-green-600">{{ $stats['active_members'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-5">
        <p class="text-sm text-gray-500">Inactive</p>
        <p class="text-3xl font-bold text-red-600">{{ $stats['inactive_members'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-5">
        <p class="text-sm text-gray-500">Pending</p>
        <p class="text-3xl font-bold text-yellow-600">{{ $stats['pending_members'] }}</p>
    </div>
</div>


<div class="bg-white rounded-lg shadow">
    <div class="px-5 py-4 border-b">
        <h2 class="text-lg font-semibold">Recent Members</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Membership ID</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Joined</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($recentMembers as $member)
                    <tr>
                        <td class="px-5 py-3 text-sm">{{ $member->name }}</td>
                        <td class="px-5 py-3 text-sm">{{ $member->membership_id }}</td>
                        <td class="px-5 py-3 text-sm">
                            <span class="px-2 py-1 text-xs rounded-full
                                @if($member->membership_status === 'active') bg-green-100 text-green-800
                                @elseif($member->membership_status === 'inactive') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst($member->membership_status) }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-sm">{{ $member->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-4 text-center text-gray-500">No members yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection