<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MTNSubProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * @var \App\Models\Product $mtn
         */

        $mtn = \App\Models\Product::where('name', 'MTN Databundle')->first();
        $mtn->update(['has_sub_product' => true]);

        $mtn->subProducts()->create([
            'name' => '100MB Daily',
            'price' => 100,
            'description' => 'DataPlan Daily',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '200MB 3-Day Plan',
            'price' => 220,
            'description' => 'DataPlan Daily',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '350MB Weekly',
            'price' => 300,
            'description' => 'DataPlan Weekly',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '750MB 2-Week Plan',
            'price' => 550,
            'description' => 'DataPlan Weekly',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '2GB Monthly Plan',
            'price' => 1200,
            'description' => 'DataPlan Monthly',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '1.5GB 1 month mobile plan',
            'price' => 1100,
            'description' => 'DataPlan Monthly',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '1GB 300 Daily',
            'price' => 300,
            'description' => 'DataPlan Daily',
            'up_product_key' => '18',
        ]);

        $mtn->subProducts()->create([
            'name' => '3GB 1500 Monthly',
            'price' => 1500,
            'description' => 'DataPlan Monthly',
            'up_product_key' => '36',
        ]);

        $mtn->subProducts()->create([
            'name' => '325GB 100000 6-Months',
            'price' => 100000,
            'description' => 'Data Bundles',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '1500GB 450000 1-Year',
            'price' => 450000,
            'description' => 'Data Bundles',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '2.5GB 550 2-Day',
            'price' => 550,
            'description' => 'DataPlan',
            'up_product_key' => '20',
        ]);

        $mtn->subProducts()->create([
            'name' => '400GB 120000 Yearly',
            'price' => 120000,
            'description' => 'DataPlan',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '75GB 20000 2-Month',
            'price' => 20000,
            'description' => 'DataPlan',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '120GB 30000 2-Month',
            'price' => 30000,
            'description' => 'DataPlan',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '150GB 50000 3-Month',
            'price' => 50000,
            'description' => 'DataPlan',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '250GB 75000 3-Month',
            'price' => 75000,
            'description' => 'DataPlan',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '25GB 6000 Monthly',
            'price' => 6000,
            'description' => 'DataPlan',
            'up_product_key' => '36',
        ]);

        $mtn->subProducts()->create([
            'name' => '1GB 550 Weekly',
            'price' => 550,
            'description' => 'DataPlan Weekly',
            'up_product_key' => '19',
        ]);

        $mtn->subProducts()->create([
            'name' => '6GB 1500 Weekly',
            'price' => 1500,
            'description' => 'DataPlan Weekly',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '6GB 2500 Monthly',
            'price' => 2500,
            'description' => 'DataPlan Monthly',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '10GB 3300 Monthly',
            'price' => 3300,
            'description' => 'DataPlan Monthly',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '110GB 20000 Monthly',
            'price' => 20000,
            'description' => 'DataPlan Monthly',
            'up_product_key' => '36',
        ]);

        $mtn->subProducts()->create([
            'name' => '25GB SME 10000 Monthly',
            'price' => 10000,
            'description' => 'DataPlan Monthly',
            'up_product_key' => '12',
        ]);

        $mtn->subProducts()->create([
            'name' => '165GB SME 50000 2-Month',
            'price' => 50000,
            'description' => 'DataPlan',
            'up_product_key' => '12',
        ]);

        $mtn->subProducts()->create([
            'name' => '360GB SME 100000 3-Month',
            'price' => 100000,
            'description' => 'DataPlan',
            'up_product_key' => '12',
        ]);

        $mtn->subProducts()->create([
            'name' => '1TB SME 250000 3-Month',
            'price' => 250000,
            'description' => 'DataPlan',
            'up_product_key' => '12',
        ]);

        $mtn->subProducts()->create([
            'name' => '4.5GB 2200 Monthly',
            'price' => 2200,
            'description' => 'DataPlan Monthly',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '12GB 3500 Monthly',
            'price' => 3500,
            'description' => 'DataPlan Monthly',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '20GB 5500 Monthly',
            'price' => 5500,
            'description' => 'DataPlan Monthly',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '40GB 10000 Monthly',
            'price' => 10000,
            'description' => 'DataPlan Monthly',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '75GB 15000 Monthly',
            'price' => 15000,
            'description' => 'DataPlan Monthly',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => 'Xtratalk 200 200 3days',
            'price' => 200,
            'description' => 'Xtratalk',
            'up_product_key' => '24',
        ]);

        $mtn->subProducts()->create([
            'name' => 'Xtratalk 300 300 Weekly',
            'price' => 300,
            'description' => 'Xtratalk',
            'up_product_key' => '24',
        ]);

        $mtn->subProducts()->create([
            'name' => 'Xtratalk 500 500 Weekly',
            'price' => 500,
            'description' => 'Xtratalk',
            'up_product_key' => '24',
        ]);

        $mtn->subProducts()->create([
            'name' => 'Xtratalk 1000 1000 Monthly',
            'price' => 1000,
            'description' => 'Xtratalk',
            'up_product_key' => '24',
        ]);

        $mtn->subProducts()->create([
            'name' => 'Xtratalk 2000 2000 Monthly',
            'price' => 2000,
            'description' => 'Xtratalk',
            'up_product_key' => '24',
        ]);

        $mtn->subProducts()->create([
            'name' => 'Xtratalk 5000 5000 Monthly',
            'price' => 5000,
            'description' => 'Xtratalk',
            'up_product_key' => '24',
        ]);

        $mtn->subProducts()->create([
            'name' => 'Xtratalk 10000 10000 Monthly',
            'price' => 10000,
            'description' => 'Xtratalk',
            'up_product_key' => '24',
        ]);

        $mtn->subProducts()->create([
            'name' => 'Xtratalk 15000 15000 Monthly',
            'price' => 15000,
            'description' => 'Xtratalk',
            'up_product_key' => '24',
        ]);

        $mtn->subProducts()->create([
            'name' => 'Xtratalk 20000 20000 Monthly',
            'price' => 20000,
            'description' => 'Xtratalk',
            'up_product_key' => '24',
        ]);

        $mtn->subProducts()->create([
            'name' => 'Xtradata 200 200 3days Bundle',
            'price' => 200,
            'description' => 'Xtradata',
            'up_product_key' => '25',
        ]);

        $mtn->subProducts()->create([
            'name' => 'Xtradata 300 300 Weekly Bundle',
            'price' => 300,
            'description' => 'Xtradata',
            'up_product_key' => '25',
        ]);

        $mtn->subProducts()->create([
            'name' => 'Xtradata 500 500 Weekly Bundle',
            'price' => 500,
            'description' => 'Xtradata',
            'up_product_key' => '25',
        ]);

        $mtn->subProducts()->create([
            'name' => 'Xtradata 1000 1000 Monthly Bundle',
            'price' => 1000,
            'description' => 'Xtradata',
            'up_product_key' => '25',
        ]);

        $mtn->subProducts()->create([
            'name' => 'Xtradata 2000 2000 Monthly Bundle',
            'price' => 2000,
            'description' => 'Xtradata',
            'up_product_key' => '25',
        ]);

        $mtn->subProducts()->create([
            'name' => 'Xtradata 5000 5000 Monthly Bundle',
            'price' => 5000,
            'description' => 'Xtradata',
            'up_product_key' => '25',
        ]);

        $mtn->subProducts()->create([
            'name' => 'Xtradata 10000 10000 Monthly Bundle',
            'price' => 10000,
            'description' => 'Xtradata',
            'up_product_key' => '25',
        ]);

        $mtn->subProducts()->create([
            'name' => 'Xtradata 15000 15000 Monthly Bundle',
            'price' => 15000,
            'description' => 'Xtradata',
            'up_product_key' => '25',
        ]);

        $mtn->subProducts()->create([
            'name' => 'Xtradata 20000 20000 Monthly Bundle',
            'price' => 20000,
            'description' => 'Xtradata',
            'up_product_key' => '25',
        ]);

        $mtn->subProducts()->create([
            'name' => '11GB Monthly Plan',
            'price' => 3000,
            'description' => 'DataPlan Monthly',
            'up_product_key' => '36',
        ]);

        $mtn->subProducts()->create([
            'name' => '13GB Monthly Plan',
            'price' => 3500,
            'description' => 'DataPlan Monthly',
            'up_product_key' => '36',
        ]);

        $mtn->subProducts()->create([
            'name' => '22GB Monthly Plan',
            'price' => 5000,
            'description' => 'DataPlan Monthly',
            'up_product_key' => '36',
        ]);

        $mtn->subProducts()->create([
            'name' => '27GB Monthly Plan',
            'price' => 6000,
            'description' => 'DataPlan Monthly',
            'up_product_key' => '36',
        ]);

    }
}
