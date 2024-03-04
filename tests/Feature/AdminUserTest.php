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

function adminUserCreate(): AdminUser
{
    $rawAdminUser = AdminUser::factory()->raw();

    $adminUser = [
        ...$rawAdminUser,
        'role_id' => Role::first()->id,
    ];

    return AdminUser::create($adminUser);
}

test('admin user list success', function () {
    authUser();
    $this->getJson("api/v1/admin-user")
        ->assertStatus(200)
        ->assertJsonStructure([
            'data'
        ]);
});


test('admin user detail success', function () {
    authUser();

    $adminUser = adminUserCreate();

    $this->getJson("api/v1/admin-user/detail/".$adminUser->id)
        ->assertStatus(200);
});

test("Admin User Update Success", function () {
    authUser();

    $adminUser = adminUserCreate();

    $rawAdminUser = AdminUser::factory()->raw();

    $updateAdminUser = [
        ...$rawAdminUser,
        'role_id' => Role::first()->id,
    ];

    $this->putJson("api/v1/admin-user/update/" . $adminUser->id, $updateAdminUser)
    ->assertStatus(200);

    $this->assertDatabaseHas('admin_users', $updateAdminUser);
});

test('role delete successfully', function () {
    authUser();

    $adminUser = adminUserCreate();

    $this->deleteJson("api/v1/admin-user/delete/" . $adminUser->id);

    $this->assertDatabaseMissing('admin_users', [
        'id' => $adminUser->id
    ]);
});