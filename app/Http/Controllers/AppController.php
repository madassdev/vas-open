<?php

namespace App\Http\Controllers;

use App\Helpers\DBSwap;
use App\Models\Business;
use App\Models\BusinessUser;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AppController extends Controller
{
    //
    public function test()
    {
        return "Nothing to test";
        $businesses = Business::all()->map(function ($business) {
            $user = $business->businessUsers()->first();
            // return @$user->email;
            DBSwap::setConnection('mysqltest');
            $test_business = Business::updateOrCreate([
                "email" => $business->business_email,
            ], [
                "name" => $business->name,
                "email" => $business->email,
                "phone" => $business->phone_number,
                "address" => $business->address,
                "current_env" => "test",
                "test_api_key" => $business->test_api_key,
                "live_enabled" => true,
                "business_category_id" => $business->business_category_id,
            ]);

            $test_business->createDummyAccount();
            $test_business->createWallet();
            // Create User

            if($user)
            {

                $test_user = User::updateOrCreate([
                    "email" => $user->email,
                ], [
                    "first_name" => $user->first_name,
                    "last_name" => $user->last_name,
                    "email" => $user->email,
                    "phone" => $user->phone_number,
                    "business_id" => $test_business->id,
                    "password" => $user->password,
                    "verification_code" => $user->password,
                    "verified" => false,
                    "password_changed" => $user->password_changed,
                ]);
            }else{
                $test_user = User::create([
                    "email" => $business->email,
                ], [
                    "first_name" => $business->name,
                    "last_name" =>$business->name,
                    "email" => $business->email,
                    "phone" => $business->phone_number,
                    "business_id" => $test_business->id,
                    "password" => bcrypt('password'),
                    "verification_code" => 'password',
                    "verified" => false,
                ]);
            }

            $test_role = Role::whereName('business_super_admin')->first();
            // Attach business to user
            $test_user->businesses()->attach($test_business->id, ["is_active" => true, "role_id" => $test_role->id]);

            // Assign role to user 
            $test_user->assignRole('business_super_admin');


            return $test_business;
        });
        return $businesses;
        // return $business;
        $test_url = "https://test.vasreseller.dv/api/static/test/save";

        // return $business->moveToTestDb();
        return Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->withOptions(['verify' => false])->post($test_url, $business)->json();
    }

    // public function save(Req $business)
    // {
    //     DBSwap::setConnection('mysqltest');
    //     $test_business = Business::updateOrCreate([
    //         "email" => $business->business_email,
    //     ], [
    //         "name" => $business->name,
    //         "email" => $business->email.'nnn',
    //         "phone" => $business->phone_number,
    //         "address" => $business->address,
    //         "current_env" => "test",
    //         "test_api_key" => $business->test_api_key,
    //         "live_enabled" => true,
    //         "business_category_id" => $business->business_category_id,
    //     ]);
    //     return response()->json([
    //         "data" => $test_business,
    //     ]);

    //     return $test_business;
    //     $test_business->createDummyAccount();
    //     $test_business->createWallet();
    //     // Create User
    //     $test_user = User::updateOrCreate([
    //         "email" => $business->email,
    //     ], [
    //         "first_name" => $business->first_name,
    //         "last_name" => $business->last_name,
    //         "email" => $business->email,
    //         "phone" => $user->phone_number,
    //         "business_id" => $test_business->id,
    //         "password" => $user->password,
    //         "verification_code" => $user->password,
    //         "verified" => false,
    //     ]);

    //     $test_role = Role::whereName('business_super_admin')->first();
    //     // Attach business to user
    //     $test_user->businesses()->attach($test_business->id, ["is_active" => true, "role_id" => $test_role->id]);

    //     // Assign role to user 
    //     $test_user->assignRole('business_super_admin');

    //     return response()->json([
    //         "data" => $business->all()
    //     ]);
    //     Log::info('received business:' . var_dump($business->all()));
    //     return $business->all();
    // return Http::withHeaders([
    //     'Content-Type' => 'application/json',
    //     'Accept' => 'application/json',
    // ])->post($this->url, $payload)->json();
    // }
}
