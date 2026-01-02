<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifiedUserMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Skip payment check if user is already active (approved by admin) or verified
        if ($user->status === 'active' || $user->registration_verified) {
            return $next($request);
        }

        // Allow access to payment routes if not verified
        if (!$request->routeIs('user.payment', 'user.payment.submit', 'user.payment.razorpay.verify')) {
            return redirect()->route('user.payment');
        }

        return $next($request);
    }
}
