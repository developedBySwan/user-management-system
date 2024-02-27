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
    public function handle(Request $request, Closure $next): Response
    {
        Role::query()
            ->withWhereHas('permissions', function ($query) {
                $query->with('feature');
            })
            ->where('id', Auth::user()->role_id)
            ->first();

        return $next($request);
    }
}
