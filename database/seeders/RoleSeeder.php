<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $roles = collect([
            "business_super_admin",
            "business_developer",
            "business_finance",
            "owner_super_admin"
        ]);

        $roles->map(function ($r) {
            Role::updateOrCreate(
                ["name" => $r],
                ["name" => $r]
            );
        });
    }
}
