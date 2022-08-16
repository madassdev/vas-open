<?php

namespace App\Console\Commands;

use App\Models\Permission;
// use App\Models\Role;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command syncs roles and permissions on the app';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $permissions  = Permission::getAppPermissions();
        $permissionForRoles = Permission::permissionForRoles();
        $this->info("Total permissions to sync: " . $permissions->count());
        $this->line('Syncing permissions...');
        $this->withProgressBar($permissions, function ($permission) {
            Permission::updateOrCreate(["name" => $permission["name"]], $permission + ["guard_name" => "web"]);
        });
        $this->newLine();
        $this->newLine();
        $this->info("Total roles to sync: " . $permissionForRoles->count());
        $this->line('Syncing Roles with permissions...');
        $this->withProgressBar($permissionForRoles, function ($permissionRole) {
            $role = Role::whereName($permissionRole["role"])->first();
            $role->syncPermissions($permissionRole["permissions"]);
        });
        $this->newLine();
        $this->newLine();
        $this->info("Operation Complete.");
        return 0;
    }
}
