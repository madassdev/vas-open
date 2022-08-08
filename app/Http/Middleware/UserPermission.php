<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        $user = auth()->user();
        // sr("User Permissions", [$user->getAllPermissions()->toArray()]);
        if (!$user->hasPermissionTo($permission)) {
            sr("User does not have the permission: [" . strtoupper($permission) . "]", [], 403);
        }

        return $next($request);
    }
}
