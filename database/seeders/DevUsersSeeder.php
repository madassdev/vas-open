<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Product;
use App\Models\Business;
use App\Models\BusinessUser;
use Illuminate\Database\Seeder;
use App\Models\BusinessCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
            [
                "first_name" => "Oluwatoyin",
                "last_name" => "Dev",
                "email" => "oluwatoyinfolarin3@gmail.com",
                "phone" => "00000000",
                "password" => "Oluwatoyin1@",
                "business_name" => "Oluwatoyin's Business",
                "business_address" => "Somewhere there",
            ],
        ])->map(function ($dev) {
            $this->createDevAccounts($dev);
        });
    }

    public function createDevAccounts($details)
    {
        $dev = (object) $details;
        $business_category_id = BusinessCategory::first()->id;
        $role = Role::whereName(sc('BUSINESS_ADMIN_ROLE'))->first();
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
            "merchant_id" => "Nameofmerchant",
            "terminal_id" => "1234",
            "client_id" => "380278fb-e23b-4d3d-8461-7b1ff73ad51f",
        ]);

        $business->createDummyAccount();
        $business->createWallet();
        $business->test_api_key = strtoupper("pk_test_seeded_" . $key);
        $business->live_api_key = strtoupper("pk_live_seeded_" . $key);
        $business->test_secret_key = strtoupper("sk_test_seeded_" . $key);
        $business->live_secret_key = strtoupper("sk_live_seeded_" . $key);
        $business->save();
        $business->products()->saveMany( Product::all() );

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
        $businessUser = BusinessUser::whereBusinessId($business->id)->whereUserId($user->id)->first();
        $businessUser->assignRole($role->name);
        $business->createDemoTransaction(30);
    }
}
