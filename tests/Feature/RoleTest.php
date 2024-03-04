<?php

use App\Models\AdminUser;
use App\Models\Permissions\Permission;
use App\Models\Permissions\Role;

test("permission list success", function () {
    authUser();

    $this->getJson('api/v1/role/permissions')
        ->assertStatus(200)
        ->assertJsonStructure([
            'data'
        ]);
});

test("role list success", function () {
    authUser();

    $this->getJson('api/v1/role/')
        ->assertStatus(200)
        ->assertJsonStructure([
            'data'
        ]);
});

test('role store success', function () {
    authUser();

    $role = [
        "name" => "Org Role",
        'permissions' => Permission::query()->pluck('id')->toArray(),
    ];

    $this->postJson('api/v1/role/store',$role)
        ->assertStatus(200);

    // $this->assertDatabaseHas('roles', $role);
});

test('role update success', function () {
    authUser();

    $roleArray = [
        "name" => "Org Role name",
    ];

    $role = Role::create($roleArray);

    $updateRoleRawArr = [
        "name" => "testing",
        "permissions" => Permission::query()->pluck('id')->toArray(),
    ];
    
    $this->putJson("api/v1/role/update/".$role->id, $updateRoleRawArr)
    ->assertStatus(200);

    $this->assertDatabaseHas('roles', [
        "name" => "testing",
    ]);
});

test('role delete success', function () {
    authUser();

    $role = Role::create([
        'name' => "testing",
    ]);

    $this->deleteJson("api/v1/role/delete/" . $role->id)
    ->assertStatus(200);

    $this->assertDatabaseMissing('roles', [
                "id" => $role->id
    ]);
});