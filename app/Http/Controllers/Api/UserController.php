<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $search = $request->input('search');
        $users = User::search($search)->orderBy('name')->paginate(15);
        return response()->json($users);
    }

    public function show(User $user): JsonResponse
    {
        return response()->json($user);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role'     => ['required', Rule::in(['admin', 'user'])],
            'membership_status' => ['nullable', Rule::in(['active', 'inactive', 'pending'])],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        if ($validated['role'] === 'user' && empty($validated['membership_id'] ?? null)) {
            $validated['membership_id'] = 'SC-' . strtoupper(uniqid());
            $validated['membership_status'] = $validated['membership_status'] ?? 'pending';
        }

        $user = User::create($validated);
        return response()->json($user, 201);
    }

    public function update(Request $request, User $user): JsonResponse
    {
        $validated = $request->validate([
            'name'              => ['sometimes', 'string', 'max:255'],
            'email'             => ['sometimes', 'email', Rule::unique('users')->ignore($user->id)],
            'password'          => ['sometimes', 'string', 'min:8'],
            'role'              => ['sometimes', Rule::in(['admin', 'user'])],
            'membership_status' => ['sometimes', Rule::in(['active', 'inactive', 'pending'])],
            'contact_number'    => ['sometimes', 'nullable', 'string', 'max:30'],
            'address'           => ['sometimes', 'nullable', 'string'],
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);
        return response()->json($user);
    }

    public function destroy(User $user): JsonResponse
    {
        $user->delete();
        return response()->json(null, 204);
    }
}