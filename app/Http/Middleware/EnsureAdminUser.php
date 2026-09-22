<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminUser
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $allowedEmails = array_filter([
            strtolower(trim((string) config('admin.default_email'))),
        ]);

        if (! $user || ! in_array(strtolower(trim((string) $user->email)), $allowedEmails, true)) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'email' => 'Akun ini tidak diizinkan mengakses dashboard admin.',
            ]);
        }

        return $next($request);
    }
}
