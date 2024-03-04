<?php

use App\Models\AdminUser;
use Laravel\Sanctum\Sanctum;
use App\Models\Permissions\Role;
use App\Models\Permissions\Permission;
use Illuminate\Support\Facades\Artisan;

function authUser()
{
    $authUser = AdminUser::factory()->raw();

    Artisan::call('install:permissions');

    Role::factory()->create()
            ->each(function ($role) {
                $role->permissions()->attach(Permission::all());
            });

    $authUser = [
        ...$authUser,
        'role_id' => Role::first()->id,
    ];

    $authUser = AdminUser::create($authUser);

    Sanctum::actingAs($authUser);
}

test('admin user list', function () {
    authUser();
    $this->getJson("api/v1/admin-user")
        ->assertStatus(200)
        ->assertJsonStructure([
            'data'
        ]);
});