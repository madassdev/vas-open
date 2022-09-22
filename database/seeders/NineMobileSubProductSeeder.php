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

        $nineMobile->subProducts()->create([
            'name' => '7GB Weekly',
            'price' => 0,
            'description' => '7GB Weekly',
            'up_product_key' => '991',
        ]);

        $nineMobile->subProducts()->create([
            'name' => '75GB Quaterly Plan',
            'price' => 0,
            'description' => '75GB Quaterly Plan',
            'up_product_key' => '991',
        ]);

        $nineMobile->subProducts()->create([
            'name' => '75GB Monthly Plan',
            'price' => 0,
            'description' => '75GB Monthly Plan',
            'up_product_key' => '991',
        ]);

        $nineMobile->subProducts()->create([
            'name' => '650MB Daily',
            'price' => 0,
            'description' => '650MB Daily',
            'up_product_key' => '991',
        ]);

        $nineMobile->subProducts()->create([
            'name' => '500MB Monthly Plan',
            'price' => 0,
            'description' => '500MB Monthly Plan',
            'up_product_key' => '991',
        ]);

        $nineMobile->subProducts()->create([
            'name' => '40GB Monthly Plan',
            'price' => 0,
            'description' => '40GB Monthly Plan',
            'up_product_key' => '991',
        ]);

        $nineMobile->subProducts()->create([
            'name' => '4.5GB Monthly Plan',
            'price' => 0,
            'description' => '4.5GB Monthly Plan',
            'up_product_key' => '991',
        ]);

        $nineMobile->subProducts()->create([
            'name' => '365GB Yearly Plan',
            'price' => 0,
            'description' => '365GB Yearly Plan',
            'up_product_key' => '991',
        ]);

        $nineMobile->subProducts()->create([
            'name' => '2GB Monthly Plan',
            'price' => 0,
            'description' => '2GB Monthly Plan',
            'up_product_key' => '991',
        ]);

        $nineMobile->subProducts()->create([
            'name' => '25MB Daily',
            'price' => 0,
            'description' => '25MB Daily',
            'up_product_key' => '991',
        ]);

        $nineMobile->subProducts()->create([
            'name' => '165GB 6months Plan',
            'price' => 0,
            'description' => '165GB 6months Plan',
            'up_product_key' => '991',
        ]);

        $nineMobile->subProducts()->create([
            'name' => '15GB Monthly Plan',
            'price' => 0,
            'description' => '15GB Monthly Plan',
            'up_product_key' => '991',
        ]);

        $nineMobile->subProducts()->create([
            'name' => '11GB Monthly Plan',
            'price' => 0,
            'description' => '11GB Monthly Plan',
            'up_product_key' => '991',
        ]);

        $nineMobile->subProducts()->create([
            'name' => '100MB Daily',
            'price' => 0,
            'description' => '100MB Daily',
            'up_product_key' => '991',
        ]);

        $nineMobile->subProducts()->create([
            'name' => '100GB 100 days Plan',
            'price' => 0,
            'description' => '100GB 100 days Plan',
            'up_product_key' => '991',
        ]);

        $nineMobile->subProducts()->create([
            'name' => '1.5GB Monthly Plan',
            'price' => 0,
            'description' => '1.5GB Monthly Plan',
            'up_product_key' => '991',
        ]);
    }
}
