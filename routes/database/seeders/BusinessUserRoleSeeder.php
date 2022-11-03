<?php

namespace Database\Seeders;

use App\Models\BusinessUser;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusinessUserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        BusinessUser::all()->map(function($businessUser){
            $role = Role::find($businessUser->role_id);
            $businessUser->syncRoles([$role->name]);
        });
    }
}
