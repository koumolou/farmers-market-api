<?php

namespace App\Http\Middleware;

use App\Http\Responses\ApiResponse;
use Closure;

class RoleMiddleware
{
    public function handle($request, Closure $next, string ...$roles)
    {
        $user = $request->user();

        if (!$user || !in_array($user->role, $roles)) {
            return ApiResponse::error('Unauthorized', 403);
        }

        return $next($request);
    }
}