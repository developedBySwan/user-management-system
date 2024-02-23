<?php

namespace Database\Factories\Permissions;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Permissions\Permission>
 */
class PermissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->title,
        ];
    }

    public function createPermission(): Factory
    {
        return $this->state(function (array $attribute) {
            return [
                'name' => 'create',
            ];
        });
    }

    public function viewPermission(): Factory
    {
        return $this->state(function (array $attribute) {
            return [
                'name' => 'view',
            ];
        });
    }

    public function updatePermission(): Factory
    {
        return $this->state(function (array $attribute) {
            return [
                'name' => 'update',
            ];
        });
    }

    public function deletePermission(): Factory
    {
        return $this->state(function (array $attribute) {
            return [
                'name' => 'delete',
            ];
        });
    }

    public function importPermission(): Factory
    {
        return $this->state(function (array $attribute) {
            return [
                'name' => 'import',
            ];
        });
    }

    public function exportPermission(): Factory
    {
        return $this->state(function (array $attribute) {
            return [
                'name' => 'export',
            ];
        });
    }

    public function printPermission(): Factory
    {
        return $this->state(function (array $attribute) {
            return [
                'name' => 'print',
            ];
        });
    }
}
