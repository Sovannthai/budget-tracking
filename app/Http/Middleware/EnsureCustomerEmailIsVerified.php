<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCustomerEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user('customer') || !$request->user('customer')->email_verified_at) {
            return $request->expectsJson()
                ? response()->json(['message' => 'Email verification required'], 403)
                : redirect()->route('customer.verification.notice');
        }

        return $next($request);
    }
}
