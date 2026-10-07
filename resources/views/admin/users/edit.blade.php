@extends('layouts.app')

@section('header', 'Edit User')

@section('content')
<div class="max-w-lg bg-white rounded-lg shadow p-6">
    <form method="POST" action="{{ route('admin.users.update', $user) }}">
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
                <label class="block text-sm font-medium text-gray-700">Email *</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">New Password (leave blank to keep)</label>
                <input type="password" name="password"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                <input type="password" name="password_confirmation"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Role *</label>
                <select name="role" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                    {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                    <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User (Senior Citizen)</option>
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @if($user->id === auth()->id())
                    <input type="hidden" name="role" value="admin">
                    <p class="text-xs text-gray-500 mt-1">You cannot change your own role.</p>
                @endif
                @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                Update User
            </button>
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection