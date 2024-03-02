<?php

namespace Database\Factories;

use App\Enums\Gender;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AdminUser>
 */
class AdminUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->name;
        return [
            'name' => $name,
            'username' => Str::slug($name),
            'phone' => fake()->phoneNumber,
            'email' => fake()->email,
            'address' => fake()->address,
            'password' => Hash::make('test'),
            'gender' => fake()->randomElement([Gender::MALE,Gender::FEMALE,Gender::OTHER]),
            'is_active' => fake()->boolean,
        ];
    }
}
