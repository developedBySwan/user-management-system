<?php

namespace App\Console\Commands\Setup;

use App\Models\Permissions\Feature;
use App\Models\Permissions\Permission;
use Illuminate\Console\Command;

class InstallPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Permission Setup For Project';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Permission::truncate();
        // Feature::truncate();

        $featurePermissions = config('permissions');

        foreach($featurePermissions as $feature => $permissions) {
            $feature = Feature::firstOrCreate([
                'name' => $feature,
            ]);

            foreach($permissions as $permission) {
                $feature->permissions()->firstOrCreate([
                    'name' => $permission,
                ]);
            }
        }
    }
}
