<?php

use App\Enums\Gender;
use App\Models\AdminUser;
use Illuminate\Support\Str;
use App\Models\Permissions\Role;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

test('exist user login', function () {
   $name = fake()->name;

   $user = AdminUser::create([
         'name' => $name,
         'username' => Str::slug($name),
         'phone' => fake()->phoneNumber,
         'email' => fake()->email,
         'address' => fake()->address,
         'password' => Hash::make('test'),
         'role_id' => Role::factory()->create()->id,
         'gender' => fake()->randomElement([Gender::Male,Gender::Female,Gender::Other]),
         'is_active' => fake()->boolean,
   ]);

   $this->postJson("api/v1/login", [
      'email' => $user->email,
      'password' => 'test'
   ])
   ->assertStatus(200)
   ->assertJsonStructure([
         'data' => [
               'user',
               'token',
         ],
   ]);
});

test('not exist use login', function () {
   $this->postJson("api/v1/login", [
      'email' =>'test@gmail.com',
      'password' => 'test'
   ])
   ->assertStatus(422)
   ->assertJson([
      "message" => "Invalid Credentials"
   ]);
});

test('user register successfully', function () {
   $adminUser = AdminUser::factory()->raw();

   $adminUser = [
      ...$adminUser,
      'role_id' => Role::factory()->create()->id,
   ];

   $authUser = AdminUser::factory()->raw();

   $authUser = [
      ...$authUser,
      'role_id' => Role::factory()->create()->id,
   ];

   $authUser = AdminUser::create($authUser);

   Sanctum::actingAs($authUser);

   $this->postJson('api/v1/user/register', $adminUser)
      ->assertStatus(200)
      ->assertJson([
            'message' => "User Create Successfully"
      ]);

    $this->assertDatabaseHas('admin_users', $adminUser);
});

test('none auth user register', function () {
   $adminUser = AdminUser::factory()->raw();

   $adminUser = [
      ...$adminUser,
      'role_id' => Role::factory()->create()->id,
   ];

   $this->postJson('api/v1/user/register', $adminUser)
      ->assertStatus(401);
});

test('auth user logout', function () {
   $authUser = AdminUser::factory()->raw();

   $authUser = [
      ...$authUser,
      'role_id' => Role::factory()->create()->id,
   ];

   $authUser = AdminUser::create($authUser);

   Sanctum::actingAs($authUser);

   $this->postJson('api/v1/user/logout')
      ->assertStatus(200)
      ->assertJson([
         'message' => 'Successfully Logout'
      ]);
});