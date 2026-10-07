<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        return view('user.dashboard', compact('user'));
    }

    public function editProfile(): View
    {
        $user = auth()->user();
        return view('user.edit-profile', compact('user'));
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'contact_number' => ['nullable', 'string', 'max:30'],
            'address'        => ['nullable', 'string'],
        ]);

        $user->update($validated);

        return redirect()
            ->route('user.dashboard')
            ->with('success', 'Profile updated successfully.');
    }
}