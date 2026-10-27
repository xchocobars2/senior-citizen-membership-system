<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to Google's OAuth page.
     */
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the callback from Google.
     */
    public function callback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Find existing user by google_id or email
            $user = User::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())
                ->first();

            if ($user) {
                // Update google_id if user existed by email only
                if (empty($user->google_id)) {
                    $user->update(['google_id' => $googleUser->getId()]);
                }
            } else {
                // Auto-register as customer/user (senior citizen role)
                $user = User::create([
                    'name'              => $googleUser->getName(),
                    'email'             => $googleUser->getEmail(),
                    'google_id'         => $googleUser->getId(),
                    'password'          => Hash::make(uniqid()), // random password
                    'role'              => 'user',
                    'membership_status' => 'pending',
                    'membership_id'     => 'SC-' . strtoupper(uniqid()),
                ]);
            }

            Auth::login($user, true); // true = remember

            // Redirect based on role
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Logged in successfully with Google.');
            }

            return redirect()->route('user.dashboard')
                ->with('success', 'Logged in successfully with Google.');

        } catch (Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Google login failed. Please try again or use email/password.');
        }
    }
}