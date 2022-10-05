<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NineMobileSubProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * @var \App\Models\Product $nineMobile
         */
        $nineMobile = \App\Models\Product::where('name', '9mobile Databundle')->first();
        $nineMobile->update(['has_sub_product' => true]);
        $nineMobile->subProducts()->create([
            'name' => '25MB Daily (1 Day-N50)',
            'price' => 50,
            'description' => 'Day Plan',
            'up_product_key' => '991',
        ]);

        $nineMobile->subProducts()->create([
            'name' => '100MB Daily (1 Day-N100)',
            'price' => 100,
            'description' => 'Day Plan',
            'up_product_key' => '991',
        ]);

        $nineMobile->subProducts()->create([
            'name' => '650MB Daily (1 Day-N200)',
            'price' => 200,
            'description' => 'Day Plan',
            'up_product_key' => '991',
        ]);

        $nineMobile->subProducts()->create([
            'name' => '7GB Weekly (7 Days-N1500)',
            'price' => 1500,
            'description' => 'Weekly Plan',
            'up_product_key' => '991',
        ]);

        $nineMobile->subProducts()->create([
            'name' => '1.5GB Monthly Plan (30 Days-N1000)',
            'price' => 1000,
            'description' => 'Monthly Plan',
            'up_product_key' => '991',
        ]);

        $nineMobile->subProducts()->create([
            'name' => '2GB Monthly Plan (30 Days-N1200)',
            'price' => 1200,
            'description' => 'Monthly Plan',
            'up_product_key' => '991',
        ]);

        $nineMobile->subProducts()->create([
            'name' => '4.5GB Monthly Plan (30 Days-N2000)',
            'price' => 2000,
            'description' => 'Monthly Plan',
            'up_product_key' => '991',
        ]);

        $nineMobile->subProducts()->create([
            'name' => '11GB Monthly Plan (30 Days-N4000)',
            'price' => 4000,
            'description' => 'Monthly Plan',
            'up_product_key' => '991',
        ]);

        $nineMobile->subProducts()->create([
            'name' => '15GB Monthly Plan (30 Days-N5000)',
            'price' => 5000,
            'description' => 'Monthly Plan',
            'up_product_key' => '991',
        ]);

        $nineMobile->subProducts()->create([
            'name' => '40GB Monthly Plan (30 Days-N10000)',
            'price' => 10000,
            'description' => 'Monthly Plan',
            'up_product_key' => '991',
        ]);

        $nineMobile->subProducts()->create([
            'name' => '75GB Monthly Plan (30 Days-N15000)',
            'price' => 15000,
            'description' => 'Monthly Plan',
            'up_product_key' => '991',
        ]);

        $nineMobile->subProducts()->create([
            'name' => '75GB Quaterly Plan (90 Days-N25000)',
            'price' => 25000,
            'description' => 'Quaterly Plan',
            'up_product_key' => '991',
        ]);

        $nineMobile->subProducts()->create([
            'name' => '165GB 6months Plan (180 Days-N50000)',
            'price' => 50000,
            'description' => '6 Months Plan',
            'up_product_key' => '991',
        ]);

    }
}
