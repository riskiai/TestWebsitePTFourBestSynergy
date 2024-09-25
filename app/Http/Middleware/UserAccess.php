<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $userRole): Response
    {
        // Validasi apakah user sudah login dan role sesuai
        if (Auth::check() && Auth::user()->role->role_name === $userRole) {
            return $next($request);
        }

        // Jika tidak sesuai, beri respon error 403
        return response()->json(['message' => 'You do not have permission to access this page.'], 403);
    }
}
