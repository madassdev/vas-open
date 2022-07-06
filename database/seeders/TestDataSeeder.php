<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\BusinessCategory;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Business
        $business = Business::updateOrCreate([
            "email" => 'testbusiness@mail.com',
        ], [
            "name" => 'Test Business',
            "email" => 'testbusiness@mail.com',
            "phone" => '08123456789',
            "address" => 'Business Address',
            "current_env" => "test"
        ]);
        // Create User for business
        $user = User::updateOrCreate([
            "email" => 'testbusiness@mail.com',
        ], [
            "first_name" => 'Test',
            "last_name" => 'User',
            "email" => 'testbusiness@mail.com',
            "phone" => '08123456789',
            "business_id" => $business->id,
            "password" => bcrypt('Password123...'),
            "verification_code" => 'Password123...',
            "verified" => false,
        ]);

        $business_category = BusinessCategory::first();
        $business->category = $business_category->name;
        $business->save();

        // Products
        $products = [
            [
                "name" => "MTN 1gb Data",
                "biller_id" => 1,
                "category" => "Databundle Services",
                "category_id" =>2,
                "description" => "MTN 1gb Data for #1200",
                "product_code" => "MTN-1GB",
                "enabled" => true,
                "service_status" => 1,
                "deployed" => true,
                "min_amount" => 1200,
                "max_amount" => 1200,
                "commission_type" => "fee",
                "has_fee" => false,
                "type" => "type 1",
                "implementation_code" => "CODE1",
            ],
            [
                "name" => "MTN 2gb Data",
                "biller_id" => 1,
                "category" => "Databundle Services",
                "category_id" =>2,
                "description" => "MTN 2gb Data for #2000",
                "product_code" => "MTN-2GB",
                "enabled" => true,
                "service_status" => 1,
                "deployed" => true,
                "min_amount" => 2000,
                "max_amount" => 2000,
                "commission_type" => "fee",
                "has_fee" => false,
                "type" => "type 1",
                "implementation_code" => "CODE2",
            ],
            [
                "name" => "GLO 1gb Data",
                "biller_id" => 2,
                "category" => "Databundle Services",
                "category_id" =>2,
                "description" => "GLO 1gb Data for #1200",
                "product_code" => "GLO-1GB",
                "enabled" => true,
                "service_status" => 1,
                "deployed" => true,
                "min_amount" => 1200,
                "max_amount" => 1200,
                "commission_type" => "fee",
                "has_fee" => false,
                "type" => "type 1",
                "implementation_code" => "CODE3",
            ],
            [
                "name" => "MTN Airtime",
                "biller_id" => 1,
                "category" => "Telco Top Up Services",
                "category_id" =>1,
                "description" => "MTN Airtime purchase",
                "product_code" => "MTN-AIRTIME",
                "enabled" => true,
                "service_status" => 1,
                "deployed" => true,
                "min_amount" => 50,
                "max_amount" => 10000,
                "commission_type" => "fee",
                "has_fee" => false,
                "type" => "type 1",
                "implementation_code" => "CODE4",
            ],
        ];
        collect($products)->map(function($product) use ($business){
            $p = Product::updateOrCreate(['name' => $product["name"]],$product);
            $p->businesses()->sync([$business->id]);
        });
    }
}
