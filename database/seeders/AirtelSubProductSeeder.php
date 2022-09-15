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
        $airtel = \App\Models\Product::where('name', 'Airtel')->first();

        $airtel->subProducts()->create([
            'name' => 'Virtual Top-up',
            'price' => 0,
            'description' => 'Virtual Top-up',
            'up_product_key' => 'EXRCTRFREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '75GB Monthly Mega Data Plan (30 Days)',
            'price' => 0,
            'description' => '75GB Monthly Mega Data Plan (30 Days)',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '750MB Weekly Data Plan (14 Days-N500)',
            'price' => 500,
            'description' => '750MB Weekly Data Plan (14 Days-N500)',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '6GB Monthly Data Plan (30 Days)',
            'price' => 0,
            'description' => '6GB Monthly Data Plan (30 Days)',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '6GB Binge Data Plan(Weekly)',
            'price' => 0,
            'description' => '6GB Binge Data Plan(Weekly)',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '500GB Monthly Mega Data Plan(4 months)',
            'price' => 0,
            'description' => '500GB Monthly Mega Data Plan(4 months)',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '40MB Daily Data Plan (1 Day-N50)',
            'price' => 50,
            'description' => '40MB Daily Data Plan (1 Day-N50)',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '40GB Monthly Mega Data Plan (30 Days)',
            'price' => 0,
            'description' => '40GB Monthly Mega Data Plan (30 Days)',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '400GB Monthly Mega Data Plan (3 months)',
            'price' => 0,
            'description' => '400GB Monthly Mega Data Plan (3 months)',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '4.5GB Monthly Data Plan (30 Days)',
            'price' => 0,
            'description' => '4.5GB Monthly Data Plan (30 Days)',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '3GB Monthly Data Plan (30 Days)',
            'price' => 0,
            'description' => '3GB Monthly Data Plan (30 Days)',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '350MB Daily Data Plan (7 Days-N300)',
            'price' => 300,
            'description' => '350MB Daily Data Plan (7 Days-N300)',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '30GB Monthly Mega Data Plan (30 Days)',
            'price' => 0,
            'description' => '30GB Monthly Mega Data Plan (30 Days)',
            'up_product_key' => 'VASSELLREQ',
        ]);

                // 14	2GB Monthly Data Plan (30 Days)	VASSELLREQ	FALSE	FALSE
        // 15	2GB Data Plan(Monthly)	VASSELLREQ	FALSE	FALSE
        // 16	2GB Binge Data Plan(1 day)	VASSELLREQ	FALSE	FALSE
        // 17	280GB Monthly Mega Data Plan (30 Days)	VASSELLREQ	FALSE	FALSE
        // 18	240GB Monthly Mega Data Plan (30 Days)	VASSELLREQ	FALSE	FALSE
        // 19	20GB Monthly Mega Data Plan (30 Days)	VASSELLREQ	FALSE	FALSE
        // 20	200MB Daily Data Plan (3 Days-N200)	VASSELLREQ	FALSE	FALSE
        // 21	1TB Yearly Mega Data Plan	VASSELLREQ	FALSE	FALSE
        // 22	1GB Binge Data Plan(1 day)	VASSELLREQ	FALSE	FALSE
        // 23	120GB Monthly Mega Data Plan (30 Days)	VASSELLREQ	FALSE	FALSE
        // 24	11GB Monthly Data Plan (30 Days)	VASSELLREQ	FALSE	FALSE
        // 25	10GB Monthly Data Plan (30 Days)	VASSELLREQ	FALSE	FALSE
        // 26	100MB Daily Data Plan (1 Day-N100)	VASSELLREQ	FALSE	FALSE
        // 27	1.5GB Monthly Data Plan (30 Days-N1000)	VASSELLREQ	FALSE	FALSE

        $airtel->subProducts()->create([
            'name' => '2GB Monthly Data Plan (30 Days)',
            'price' => 0,
            'description' => '2GB Monthly Data Plan (30 Days)',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '2GB Data Plan(Monthly)',
            'price' => 0,
            'description' => '2GB Data Plan(Monthly)',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '2GB Binge Data Plan(1 day)',
            'price' => 0,
            'description' => '2GB Binge Data Plan(1 day)',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '280GB Monthly Mega Data Plan (30 Days)',
            'price' => 0,
            'description' => '280GB Monthly Mega Data Plan (30 Days)',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '240GB Monthly Mega Data Plan (30 Days)',
            'price' => 0,
            'description' => '240GB Monthly Mega Data Plan (30 Days)',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '20GB Monthly Mega Data Plan (30 Days)',
            'price' => 0,
            'description' => '20GB Monthly Mega Data Plan (30 Days)',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '200MB Daily Data Plan (3 Days-N200)',
            'price' => 200,
            'description' => '200MB Daily Data Plan (3 Days-N200)',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '1TB Yearly Mega Data Plan',
            'price' => 0,
            'description' => '1TB Yearly Mega Data Plan',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '1GB Binge Data Plan(1 day)',
            'price' => 0,
            'description' => '1GB Binge Data Plan(1 day)',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '120GB Monthly Mega Data Plan (30 Days)',
            'price' => 0,
            'description' => '120GB Monthly Mega Data Plan (30 Days)',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '11GB Monthly Data Plan (30 Days)',
            'price' => 0,
            'description' => '11GB Monthly Data Plan (30 Days)',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '10GB Monthly Data Plan (30 Days)',
            'price' => 0,
            'description' => '10GB Monthly Data Plan (30 Days)',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '100MB Daily Data Plan (1 Day-N100)',
            'price' => 100,
            'description' => '100MB Daily Data Plan (1 Day-N100)',
            'up_product_key' => 'VASSELLREQ',
        ]);

        $airtel->subProducts()->create([
            'name' => '1.5GB Monthly Data Plan (30 Days-N1000)',
            'price' => 1000,
            'description' => '1.5GB Monthly Data Plan (30 Days-N1000)',
            'up_product_key' => 'VASSELLREQ',
        ]);
    }
}
