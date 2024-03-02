<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use App\Models\Permissions\Role;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AdminUser::truncate();
        
        AdminUser::factory()
            ->for(Role::factory())
            ->count(10)->create();
    }
}
