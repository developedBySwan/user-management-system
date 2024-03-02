<?php

use Illuminate\Support\Facades\Cache;

if (! function_exists('can_access')) {
    function can_access($feature, $permission): bool
    {
        $role = Cache::rememberForever(auth()->user()->role_id, function () {
            return \App\Models\Permissions\Role::query()
            ->with([
                'permissions' => [
                    'feature'
                ]
            ])
            ->findOrFail(auth()->user()->role_id);
        });

        return (bool) ($role->permissions
                    ->where('name', $permission)
                    ->filter(fn ($permission) => $permission->feature->name == $feature)
                    ->count() > 0);
    }
}