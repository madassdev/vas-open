<?php

namespace Database\Seeders;

use App\Models\Role;
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
        $p =
            [
                "name" => "approve_business_documents",
                "guard_name" => "web",
                "readable_name" => "Approve/Reject Business Documents",
                "description" => null,
                "is_admin" => true
            ];
        Permission::updateOrCreate(
            ["name" => $p["name"]],
            $p
        );
    }
}
