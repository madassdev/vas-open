<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role as ModelsRole;

class AdminEnableProductPermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $product_enable_permission = [
            "name" => "toggle_product_enabled",
            "guard_name" => "web",
            "readable_name" => "Enable or Disable Product for a Business",
            "is_admin" => true
        ];

        $permission = Permission::updateOrCreate(
            [
                "name" =>  "toggle_product_enabled"
            ],
            $product_enable_permission
        );

        $super_admin_role = ModelsRole::whereName(sc('SUPER_ADMIN_ROLE'))->first();
        $super_admin_role->permissions()->syncWithoutDetaching([$permission->id]);


    }
}
