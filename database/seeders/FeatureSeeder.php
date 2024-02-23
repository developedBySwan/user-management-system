<?php

namespace Database\Seeders;

use App\Models\Permissions\Feature;
use App\Models\Permissions\Permission;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Feature::factory()
            ->count(10)
            ->create()
            ->each(function ($feature) {
                Permission::factory()->for($feature)->createPermission()->create();
                Permission::factory()->for($feature)->viewPermission()->create();
                Permission::factory()->for($feature)->updatePermission()->create();
                Permission::factory()->for($feature)->deletePermission()->create();
                Permission::factory()->for($feature)->importPermission()->create();
                Permission::factory()->for($feature)->exportPermission()->create();
                Permission::factory()->for($feature)->printPermission()->create();
            });
    }
}
