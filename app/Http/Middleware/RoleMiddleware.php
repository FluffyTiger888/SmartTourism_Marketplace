<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->role !== $role) {
            abort(403, 'You are not allowed to access this page.');
        }

        if (isset(auth()->user()->is_active) && auth()->user()->is_active == false) {
            auth()->logout();

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Your account has been deactivated. Please contact admin.'
                ]);
        }

        return $next($request);
    }
}