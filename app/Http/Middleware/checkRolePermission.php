<?php

namespace App\Http\Middleware;

use App\Models\Permissions\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class checkRolePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $feature, $permission): Response
    {
        $role = Role::query()
            ->withWhereHas(
                'permissions',
                fn ($query) => $query
                    ->where('name', $permission)
                    ->withWhereHas(
                        'feature',
                        fn ($query) => $query
                        ->where('name', $feature)
                    )
            )
            ->where('id', Auth::user()->role_id)
            ->first();

        if($role == null) {
            abort(401, "You Don't have permission for this actions");
        }

        return $next($request);
    }
}
