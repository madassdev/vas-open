<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class RoleFixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $superAdminRole = Role::whereName('super_admin')->first();
        $permissions = collect([
            [
                "name" => "approve_business_documents",
                "guard_name" => "web",
                "readable_name" => "Approve/Reject Business Documents",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "create_businesses",
                "guard_name" => "web",
                "readable_name" => "Create Businesses",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "view_request_logs",
                "guard_name" => "web",
                "readable_name" => "View Request Logs",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "toggle_product_enabled",
                "guard_name" => "web",
                "readable_name" => "Toggle product enable on business",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "list_products",
                "guard_name" => "web",
                "readable_name" => "List Products",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "edit_products",
                "guard_name" => "web",
                "readable_name" => "Edit products",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "list_billers",
                "guard_name" => "web",
                "readable_name" => "List billers",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "edit_billers",
                "guard_name" => "web",
                "readable_name" => "Edit billers",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "list_banks",
                "guard_name" => "web",
                "readable_name" => "List banks",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "edit_banks",
                "guard_name" => "web",
                "readable_name" => "Edit banks",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "list_admins",
                "guard_name" => "web",
                "readable_name" => "List Admin Users",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "create_admin",
                "guard_name" => "web",
                "readable_name" => "Create  Admin",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "manage_roles",
                "guard_name" => "web",
                "readable_name" => "Manage Roles",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "view_logs",
                "guard_name" => "web",
                "readable_name" => "View Logs",
                "description" => null,
                "is_admin" => true
            ],
        ])->map(function ($p) use ($superAdminRole) {

            $per = Permission::updateOrCreate(
                ["name" => $p["name"]],
                $p
            );
            $superAdminRole->permissions()->syncWithoutDetaching($per->id);
        });
    }
}
