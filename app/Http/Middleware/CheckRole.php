<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return $this->respondWithRedirect($request, '/login', 'Unauthorized access. Please log in.');
        }

        $user = Auth::user();

        if (!in_array($user->role, $roles)) {
            return $this->respondWithRedirect($request, '/', 'Forbidden: You do not have the required permissions.');
        }

        return $next($request);
    }

    private function respondWithRedirect($request, $redirectUrl, $message)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => $message], 403);
        }

        return redirect($redirectUrl)->withErrors($message);
    }
}
