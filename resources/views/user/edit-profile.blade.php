@extends('layouts.app')

@section('header', 'Edit My Profile')

@section('content')
<div class="max-w-lg bg-white rounded-lg shadow p-6">
    <p class="text-sm text-gray-500 mb-4">
        You can update your name, contact number, and address. Other membership details can only be changed by an administrator.
    </p>

    <form method="POST" action="{{ route('user.profile.update') }}">
        @csrf
        @method('PUT')

        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Full Name *</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Contact Number</label>
                <input type="text" name="contact_number" value="{{ old('contact_number', $user->contact_number) }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('contact_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Address</label>
                <textarea name="address" rows="3"
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('address', $user->address) }}</textarea>
                @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                Save Changes
            </button>
            <a href="{{ route('user.dashboard') }}" class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection