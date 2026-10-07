<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MembershipController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $members = User::members()
            ->search($search)
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.memberships.index', compact('members', 'search'));
    }

    public function create(): View
    {
        return view('admin.memberships.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'email'             => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'          => ['required', 'string', 'min:8', 'confirmed'],
            'membership_id'     => ['nullable', 'string', 'max:50', 'unique:users,membership_id'],
            'date_of_birth'     => ['nullable', 'date'],
            'contact_number'    => ['nullable', 'string', 'max:30'],
            'address'           => ['nullable', 'string'],
            'membership_status' => ['required', Rule::in(['active', 'inactive', 'pending'])],
            'membership_date'   => ['nullable', 'date'],
            'expiry_date'       => ['nullable', 'date', 'after_or_equal:membership_date'],
            'notes'             => ['nullable', 'string'],
        ]);

        $validated['role'] = 'user';
        $validated['password'] = Hash::make($validated['password']);

        if (empty($validated['membership_id'])) {
            $validated['membership_id'] = 'SC-' . strtoupper(uniqid());
        }

        User::create($validated);

        return redirect()
            ->route('admin.memberships.index')
            ->with('success', 'Senior citizen membership created successfully.');
    }

    public function show(User $membership): View
    {
        abort_unless($membership->isUser(), 404);
        return view('admin.memberships.show', compact('membership'));
    }

    public function edit(User $membership): View
    {
        abort_unless($membership->isUser(), 404);
        return view('admin.memberships.edit', compact('membership'));
    }

    public function update(Request $request, User $membership): RedirectResponse
    {
        abort_unless($membership->isUser(), 404);

        $validated = $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'email'             => ['required', 'email', 'max:255', Rule::unique('users')->ignore($membership->id)],
            'password'          => ['nullable', 'string', 'min:8', 'confirmed'],
            'membership_id'     => ['nullable', 'string', 'max:50', Rule::unique('users')->ignore($membership->id)],
            'date_of_birth'     => ['nullable', 'date'],
            'contact_number'    => ['nullable', 'string', 'max:30'],
            'address'           => ['nullable', 'string'],
            'membership_status' => ['required', Rule::in(['active', 'inactive', 'pending'])],
            'membership_date'   => ['nullable', 'date'],
            'expiry_date'       => ['nullable', 'date', 'after_or_equal:membership_date'],
            'notes'             => ['nullable', 'string'],
        ]);

        if (! empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $membership->update($validated);

        return redirect()
            ->route('admin.memberships.index')
            ->with('success', 'Membership updated successfully.');
    }

    public function destroy(User $membership): RedirectResponse
    {
        abort_unless($membership->isUser(), 404);
        $membership->delete();

        return redirect()
            ->route('admin.memberships.index')
            ->with('success', 'Membership deleted successfully.');
    }
}