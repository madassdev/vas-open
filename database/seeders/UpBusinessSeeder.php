<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\BusinessCategory;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpBusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $details= [
            "first_name" => "UP",
            "last_name" => "Admin",
            "email" => "admin@up-ng.com",
            "phone" => "00000000",
            "password" => "AdminUp123...",
            "business_name" => "Up Admin's Business",
            "business_address" => "UP Business Address",
        ];
        $admin = (object) $details;
        $business_category_id = BusinessCategory::first()->id;
        $role = Role::whereName('business_super_admin')->first();
        $adminRole = Role::whereName('owner_super_admin')->first();

        $key = md5($admin->email);

        $business = Business::updateOrCreate([
            "email" => $admin->email,
        ], [
            "name" => $admin->business_name,
            "email" => $admin->email,
            "phone" => $admin->phone,
            "address" => $admin->business_address,
            "current_env" => "test",
            "live_enabled" => true,
            "business_category_id" => $business_category_id,
        ]);

        $business->createDummyAccount();
        $business->createWallet();
        $business->test_api_key = strtoupper("pk_test_" . $key);
        $business->live_api_key = strtoupper("pk_live_" . $key);
        $business->test_secret_key = strtoupper("sk_test_" . $key);
        $business->live_secret_key = strtoupper("sk_live_" . $key);
        $business->save();

        $user = User::updateOrCreate([
            "email" => $admin->email,
        ], [
            "first_name" => $admin->first_name,
            "last_name" => $admin->last_name,
            "email" => $admin->email,
            "phone" => $admin->phone,
            "business_id" => $business->id,
            "password" => bcrypt($admin->password),
            "verified" => false,
            "password_changed" => true,
        ]);

        $user->businesses()->attach($business->id, ["is_active" => true, 'role_id' => $role->id]);

        // Assign role to user 
        $user->assignRole('business_super_admin');
        $user->assignRole('owner_super_admin');

        $business->createDemoTransaction(30);
    }
}
