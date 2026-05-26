<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HasApprovedBusinessAccount
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth('api')->user();

        $hasApproved = $user->businessAccounts()
            ->where('status', 'approved')
            ->where('is_active', true)
            ->exists();

        if (! $hasApproved) {
            return response()->json([
                'message' => __('business.no_approved_account'),
            ], 403);
        }

        return $next($request);
    }
}
