<?php

namespace App\Console\Commands\Setup;

use App\Models\Permissions\Permission;
use App\Models\Permissions\Role;
use Illuminate\Console\Command;

class SetUpProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:project';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Project Setup';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('install:permissions');

        $roleName = $this->output->ask("What will be default Role Name? default is Master", "master");

        $role = Role::create([
            'name' => $roleName
        ]);

        $role->permissions()->attach(Permission::all());

        $this->output->success("Create Successfully");
    }
}
