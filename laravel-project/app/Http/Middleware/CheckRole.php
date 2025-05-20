<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Enums\Role;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        if (!$user || !in_array($role, $user->roles ?? [])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
