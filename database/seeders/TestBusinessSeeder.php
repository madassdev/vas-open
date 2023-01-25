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

class TestBusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $details =   [
            "first_name" => "Johnny",
            "last_name" => "test",
            "email" => "johnny@test.com",
            "phone" => "08012345678",
            "password" => "Password202!",
            "business_name" => "Johnny Test Business",
            "business_address" => "Somewhere here",
        ];
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
            "merchant_id" => "SALPAY",
            "terminal_id" => "4723120541",
            "client_id" => "380278fb-e23b-4d3d-8461-7b1ff73ad51f"
        ]);

        $business->createDummyAccount();
        $business->createWallet();
        $business->test_api_key = strtoupper("pk_test_seeded_" . $key);
        $business->live_api_key = strtoupper("pk_live_seeded_" . $key);
        $business->test_secret_key = strtoupper("sk_test_seeded_" . $key);
        $business->live_secret_key = strtoupper("sk_live_seeded_" . $key);
        $business->save();
        $business->products()->saveMany(Product::all());

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
        // $business->createDemoTransaction(30);
    }
}
