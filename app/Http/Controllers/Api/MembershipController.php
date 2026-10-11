<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class MembershipController extends Controller
{
    /**
     * GET /api/memberships
     */
    public function index(Request $request): JsonResponse
    {
        $search = $request->query('search');

        $memberships = User::members()
            ->search($search)
            ->orderBy('name')
            ->paginate(15);

        return response()->json([
            'success' => true,
            'message' => 'Memberships retrieved successfully.',
            'data'    => $memberships,
        ], 200);
    }

    /**
     * GET /api/memberships/{id}
     */
    public function show(string $id): JsonResponse
    {
        $membership = User::members()->find($id);

        if (!$membership) {
            return response()->json([
                'success' => false,
                'message' => 'Membership not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Membership retrieved successfully.',
            'data'    => $membership,
        ], 200);
    }

    /**
     * POST /api/memberships
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name'              => ['required', 'string', 'max:255'],
                'email'             => ['required', 'email', 'max:255', 'unique:users,email'],
                'password'          => ['required', 'string', 'min:8'],
                'membership_id'     => ['nullable', 'string', 'max:50', 'unique:users,membership_id'],
                'date_of_birth'     => ['nullable', 'date'],
                'contact_number'    => ['nullable', 'string', 'max:30'],
                'address'           => ['nullable', 'string'],
                'membership_status' => ['required', Rule::in(['active', 'inactive', 'pending'])],
                'membership_date'   => ['nullable', 'date'],
                'expiry_date'       => ['nullable', 'date', 'after_or_equal:membership_date'],
                'notes'             => ['nullable', 'string'],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors'  => $e->errors(),
            ], 422);
        }

        $validated['role'] = 'user';
        $validated['password'] = Hash::make($validated['password']);

        if (empty($validated['membership_id'])) {
            $validated['membership_id'] = 'SC-' . strtoupper(uniqid());
        }

        $membership = User::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Membership created successfully.',
            'data'    => $membership,
        ], 201);
    }

    /**
     * PUT / PATCH /api/memberships/{id}
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $membership = User::members()->find($id);

        if (!$membership) {
            return response()->json([
                'success' => false,
                'message' => 'Membership not found.',
            ], 404);
        }

        try {
            $validated = $request->validate([
                'name'              => ['sometimes', 'required', 'string', 'max:255'],
                'email'             => ['sometimes', 'required', 'email', 'max:255', Rule::unique('users')->ignore($membership->id)],
                'password'          => ['sometimes', 'nullable', 'string', 'min:8'],
                'membership_id'     => ['sometimes', 'nullable', 'string', 'max:50', Rule::unique('users')->ignore($membership->id)],
                'date_of_birth'     => ['sometimes', 'nullable', 'date'],
                'contact_number'    => ['sometimes', 'nullable', 'string', 'max:30'],
                'address'           => ['sometimes', 'nullable', 'string'],
                'membership_status' => ['sometimes', 'required', Rule::in(['active', 'inactive', 'pending'])],
                'membership_date'   => ['sometimes', 'nullable', 'date'],
                'expiry_date'       => ['sometimes', 'nullable', 'date', 'after_or_equal:membership_date'],
                'notes'             => ['sometimes', 'nullable', 'string'],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors'  => $e->errors(),
            ], 422);
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $membership->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Membership updated successfully.',
            'data'    => $membership->fresh(),
        ], 200);
    }

    /**
     * DELETE /api/memberships/{id}
     */
    public function destroy(string $id): JsonResponse
    {
        $membership = User::members()->find($id);

        if (!$membership) {
            return response()->json([
                'success' => false,
                'message' => 'Membership not found.',
            ], 404);
        }

        $membership->delete();

        return response()->json([
            'success' => true,
            'message' => 'Membership deleted successfully.',
        ], 200);
    }
}