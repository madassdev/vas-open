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

        $mtn->subProducts()->create([
            'name' => 'Virtual Top Up',
            'price' => 0,
            'description' => 'Virtual top up',
            'up_product_key' => '1',
        ]);

        $mtn->subProducts()->create([
            'name' => 'Postpaid Bill payment',
            'price' => 0,
            'description' => 'Postpaid Bill payment',
            'up_product_key' => '1',
        ]);

        $mtn->subProducts()->create([
            'name' => '2GO 20MB DAILY',
            'price' => 9,
            'description' => '2GO 20MB DAILY',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '75MB DAILY',
            'price' => 9,
            'description' => '75MB DAILY',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '350MB DAILY',
            'price' => 0,
            'description' => '350MB DAILY',
            'up_product_key' => '18',
        ]);

        $mtn->subProducts()->create([
            'name' => '200MB 2-DAY',
            'price' => 9,
            'description' => '200MB 2-DAY',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '750MB 2-DAY',
            'price' => 0,
            'description' => '750MB 2-DAY',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '1.5GB Monthly Plan',
            'price' => 9,
            'description' => '1.5GB Monthly Plan',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '2GB Monthly Plan',
            'price' => 9,
            'description' => '2GB Monthly Plan',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '4.5GB Monthly Plan',
            'price' => 9,
            'description' => '4.5GB Monthly Plan',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '6GB Monthly Plan',
            'price' => 0,
            'description' => '6GB Monthly Plan',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '10GB + 4GB YouTube Night Monthly plan',
            'price' => 0,
            'description' => '10GB + 4GB YouTube Night Monthly plan',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '15GB Monthly Plan',
            'price' => 0,
            'description' => '15GB Monthly Plan',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '40GB Monthly Plan',
            'price' => 0,
            'description' => '40GB Monthly Plan',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '350MB Weekly Plan',
            'price' => 0,
            'description' => '350MB Weekly Plan',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '20GB Weekly Plan',
            'price' => 0,
            'description' => '20GB Weekly Plan',
            'up_product_key' => '36',
        ]);

        $mtn->subProducts()->create([
            'name' => '75GB 2 Months Plan',
            'price' => 9,
            'description' => '75GB 2 Months Plan',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '120GB 2 Months Plan',
            'price' => 9,
            'description' => '120GB 2 Months Plan',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '150GB 3 Months Plan',
            'price' => 9,
            'description' => '150GB 3 Months Plan',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '250GB 3 Months Plan',
            'price' => 9,
            'description' => '250GB 3 Months Plan',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => 'Virtual Top-up (AWUF4U)',
            'price' => 1,
            'description' => 'Virtual Top-up (AWUF4U)',
            'up_product_key' => '1',
        ]);

        $mtn->subProducts()->create([
            'name' => '2GO 50MB Weekly',
            'price' => 9,
            'description' => '2GO 50MB Weekly',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '6GB Weekly Plan',
            'price' => 9,
            'description' => '6GB Weekly Plan',
            'up_product_key' => '9',
        ]);
        $mtn->subProducts()->create([
            'name' => '1GB Weekly',
            'price' => 19,
            'description' => '1GB Weekly',
            'up_product_key' => '19',
        ]);

        $mtn->subProducts()->create([
            'name' => '2GO 160MB Monthly Plan',
            'price' => 9,
            'description' => '2GO 160MB Monthly Plan',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '8GB Monthly Plan',
            'price' => 9,
            'description' => '8GB Monthly Plan',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '75GB Monthly Plan',
            'price' => 9,
            'description' => '75GB Monthly Plan',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '3GB Monthly Plan',
            'price' => 36,
            'description' => '3GB Monthly Plan',
            'up_product_key' => '36',
        ]);

        $mtn->subProducts()->create([
            'name' => '25GB Monthly Plan',
            'price' => 36,
            'description' => '25GB Monthly Plan',
            'up_product_key' => '36',
        ]);

        $mtn->subProducts()->create([
            'name' => '110GB Monthly Plan',
            'price' => 36,
            'description' => '110GB Monthly Plan',
            'up_product_key' => '36',
        ]);

        $mtn->subProducts()->create([
            'name' => '325GB 6 Month Plan',
            'price' => 9,
            'description' => '325GB 6 Month Plan',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '1000GB Yearly Plan',
            'price' => 9,
            'description' => '1000GB Yearly Plan',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '1500GB Yearly Plan',
            'price' => 9,
            'description' => '1500GB Yearly Plan',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '400GB Yearly Plan',
            'price' => 9,
            'description' => '400GB Yearly Plan',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '30GB',
            'price' => 12,
            'description' => '30GB',
            'up_product_key' => '12',
        ]);

        $mtn->subProducts()->create([
            'name' => '90GB',
            'price' => 12,
            'description' => '90GB',
            'up_product_key' => '12',
        ]);

        $mtn->subProducts()->create([
            'name' => '150GB',
            'price' => 12,
            'description' => '150GB',
            'up_product_key' => '12',
        ]);

        $mtn->subProducts()->create([
            'name' => 'SME 150GB for 90Days(SpecialOffer)',
            'price' => 12,
            'description' => 'SME 150GB for 90Days(SpecialOffer)',
            'up_product_key' => '12',
        ]);

        $mtn->subProducts()->create([
            'name' => '1GB Daily Plan',
            'price' => 9,
            'description' => '1GB Daily Plan',
            'up_product_key' => '9',
        ]);


        $mtn->subProducts()->create([
            'name' => '2GB 2-DAY Daily Plan',
            'price' => 9,
            'description' => '2GB 2-DAY Daily Plan',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '2.5GB 2-Day Daily Plan',
            'price' => 20,
            'description' => '2.5GB 2-Day Daily Plan',
            'up_product_key' => '20',
        ]);

        $mtn->subProducts()->create([
            'name' => '1 Month All day Plan',
            'price' => 9,
            'description' => '1 Month All day Plan',
            'up_product_key' => '9',
        ]);

        $mtn->subProducts()->create([
            'name' => '12GB Monthly Plan',
            'price' => 9,
            'description' => '12GB Monthly Plan',
            'up_product_key' => '9',
        ]);
    }
}
