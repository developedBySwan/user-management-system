<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

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
            'gender' => fake()->randomElement(['male','female','other']),
            'is_active' => fake()->boolean,
        ];
    }
}
