@extends('layouts.app')

@section('header', 'Add New Membership')

@section('content')
<div class="max-w-2xl bg-white rounded-lg shadow p-6">
    <form method="POST" action="{{ route('admin.memberships.store') }}">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Full Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Email *</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Password *</label>
                <input type="password" name="password" required
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Confirm Password *</label>
                <input type="password" name="password_confirmation" required
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Membership ID</label>
                <input type="text" name="membership_id" value="{{ old('membership_id') }}"
                       placeholder="Leave blank to auto-generate"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('membership_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Contact Number</label>
                <input type="text" name="contact_number" value="{{ old('contact_number') }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Membership Status *</label>
                <select name="membership_status" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="pending" {{ old('membership_status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="active" {{ old('membership_status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('membership_status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Membership Date</label>
                <input type="date" name="membership_date" value="{{ old('membership_date') }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Expiry Date</label>
                <input type="date" name="expiry_date" value="{{ old('expiry_date') }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>
        </div>

        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-700">Address</label>
            <textarea name="address" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('address') }}</textarea>
        </div>

        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-700">Notes</label>
            <textarea name="notes" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('notes') }}</textarea>
        </div>

        <div class="mt-6 flex gap-3">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                Save Membership
            </button>
            <a href="{{ route('admin.memberships.index') }}" class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection