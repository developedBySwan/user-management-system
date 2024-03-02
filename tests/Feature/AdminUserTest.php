<?php

use App\Models\AdminUser;
use App\Models\Permissions\Role;
use Laravel\Sanctum\Sanctum;

function authUser()
{
    $authUser = AdminUser::factory()->raw();

    $authUser = [
        ...$authUser,
        'role_id' => Role::factory()->create()->id,
    ];

    $authUser = AdminUser::create($authUser);

    Sanctum::actingAs($authUser);
}

test('admin user list', function () {
   $authUser = AdminUser::factory()->raw();

   $authUser = [
      ...$authUser,
      'role_id' => Role::factory()->create()->id,
   ];

   $authUser = AdminUser::create($authUser);

   Sanctum::actingAs($authUser);

    $this->getJson("api/v1/admin-user")
    ->assertStatus(200)
    ->assertJsonStructure([
        'data'
    ]);
});