<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\BusinessCategory;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DevUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $users = collect([
            [
                "first_name" => "Frank",
                "last_name" => "Dev",
                "email" => "favescsskr@gmail.com",
                "phone" => "08136051712",
                "password" => "Faves123...",
                "business_name" => "Frank's Business",
                "business_address" => "Somewhere here",
            ],
            [
                "first_name" => "Seun",
                "last_name" => "Dev",
                "email" => "oluwaseunoffice@gmail.com",
                "phone" => "00000000",
                "password" => "Password202!",
                "business_name" => "Seun's Business",
                "business_address" => "Somewhere here",
            ],
        ])->map(function ($dev) {
            $this->createDevAccounts($dev);
        });
    }

    public function createDevAccounts($details)
    {
        $dev = (object) $details;
        $business_category_id = BusinessCategory::first()->id;
        $role = Role::whereName('business_super_admin')->first();
        $key = md5($dev->email);

        $business = Business::updateOrCreate([
            "email" => $dev->email,
        ], [
            "name" => $dev->business_name,
            "email" => $dev->email,
            "phone" => $dev->phone,
            "address" => $dev->business_address,
            "current_env" => "test",
            "live_enabled" => true,
            "business_category_id" => $business_category_id,
        ]);

        $business->createDummyAccount();
        $business->createWallet();
        $business->test_api_key = strtoupper("pk_test_seeded_" . $key);
        $business->live_api_key = strtoupper("pk_live_seeded_" . $key);
        $business->test_secret_key = strtoupper("sk_test_seeded_" . $key);
        $business->live_secret_key = strtoupper("sk_live_seeded_" . $key);
        $business->save();

        $user = User::updateOrCreate([
            "email" => $dev->email,
        ], [
            "first_name" => $dev->first_name,
            "last_name" => $dev->last_name,
            "email" => $dev->email,
            "phone" => $dev->phone,
            "business_id" => $business->id,
            "password" => bcrypt($dev->password),
            "verified" => false,
            "password_changed" => true,
        ]);

        $user->businesses()->attach($business->id, ["is_active" => true, 'role_id' => $role->id]);

        // Assign role to user 
        $user->assignRole('business_super_admin');

        $business->createDemoTransaction(30);
    }
}