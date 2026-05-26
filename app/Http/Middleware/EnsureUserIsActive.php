<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth('api')->user();

        if ($user && ! $user->is_active) {
            return response()->json([
                'message' => __('auth.account_not_verified'),
            ], 403);
        }

        return $next($request);
    }
}
