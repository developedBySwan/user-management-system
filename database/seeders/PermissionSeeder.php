<?php

namespace Database\Seeders;

use App\Models\Permissions\Permission;
use App\Models\Permissions\Feature;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::factory()
            ->for(Feature::factory())
            ->count(2)
            ->create();
    }
}
