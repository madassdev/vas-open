<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AirtelSubProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * @var \App\Models\Product $airtel
         */
        $airtel = \App\Models\Product::where('name', 'Airtel Databundle')->first();
        $airtel->update(['has_sub_product' => true]);

        $airtel->subProducts()->create([
            'name' => '40MB Daily Data Plan (1 Day-N50)',
            'price' => 50,
            'description' => 'Daily / Weekly Data Plan',
            'up_product_key' => 'VASSELLREQ'
        ]);

        $airtel->subProducts()->create([
            'name' => '100MB Daily Data Plan (1 Day-N100)',
            'price' => 100,
            'description' => 'Daily / Weekly Data Plan',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '200MB Daily Data Plan (3 Days-N200)',
            'price' => 200,
            'description' => 'Daily / Weekly Data Plan',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '350MB Daily Data Plan (7 Days-N300)',
            'price' => 300,
            'description' => 'Daily / Weekly Data Plan',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '750MB Weekly Data Plan (14 Days-N500)',
            'price' => 500,
            'description' => 'Daily / Weekly Data Plan',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '1.5GB Monthly Data Plan (30 Days-N1000)',
            'price' => 1000,
            'description' => 'Data Bundle',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '3GB Monthly Data Plan (30 Days)',
            'price' => 1500,
            'description' => 'Data Bundle',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '4.5GB Monthly Data Plan (30 Days)',
            'price' => 2000,
            'description' => 'Data Bundle',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '6GB Monthly Data Plan (30 Days)',
            'price' => 2500,
            'description' => 'Data Bundle',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '10GB Monthly Data Plan (30 Days)',
            'price' => 3000,
            'description' => 'Data Bundle',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '11GB Monthly Data Plan (30 Days)',
            'price' => 4000,
            'description' => 'Data Bundle',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '20GB Monthly Mega Data Plan (30 Days)',
            'price' => 5000,
            'description' => 'Mega Data Plan',
            'up_product_key' => 'VASSELLREQ',
        ]);
        $airtel->subProducts()->create([
            'name' => '40GB Monthly Mega Data Plan (30 Days)',
            'price' => 10000,
            'description' => 'Mega Data Plan',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '75GB Monthly Mega Data Plan (30 Days)',
            'price' => 15000,
            'description' => 'Mega Data Plan',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '120GB Monthly Mega Data Plan (30 Days)',
            'price' => 20000,
            'description' => 'Mega Data Plan',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '500MB Monthly Plan (30 Days)',
            'price' => 500,
            'description' => 'Mega Data Plan',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '400GB Monthly Mega Data Plan (3 months)',
            'price' => 50000,
            'description' => 'Mega Data Plan',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '500GB Monthly Mega Data Plan(4 months)',
            'price' => 60000,
            'description' => 'Mega Data Plan',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '1TB Yearly Mega Data Plan',
            'price' => 100000,
            'description' => 'Mega Data Plan',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '2GB Monthly Plan',
            'price' => 1200,
            'description' => 'Data Bundle',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '1GB Binge Data Plan(1 day)',
            'price' => 300,
            'description' => 'Binge Data Plan',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '2GB Binge Data Plan(1 day)',
            'price' => 500,
            'description' => 'Binge Data Plan',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '6GB Binge Data Plan(Weekly)',
            'price' => 1500,
            'description' => 'Binge Data Plan',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '2GB Data Plan(Monthly)',
            'price' => 1200,
            'description' => 'Data Bundle',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '30GB Monthly Mega Data Plan (30 Days)',
            'price' => 8000,
            'description' => 'Mega Data Plan',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '240GB Monthly Mega Data Plan (30 Days)',
            'price' => 30000,
            'description' => 'Mega Data Plan',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '280GB Monthly Mega Data Plan (30 Days)',
            'price' => 36000,
            'description' => 'Mega Data Plan',
            'up_product_key' => 'VASSELLREQ',
        ]);
    }
}