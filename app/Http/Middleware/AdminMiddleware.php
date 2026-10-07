<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isAdmin()) {
            if ($request->user()) {
                return redirect()->route('user.dashboard')
                    ->with('error', 'You do not have permission to access the admin area.');
            }
            return redirect()->route('login');
        }

        return $next($request);
    }
}