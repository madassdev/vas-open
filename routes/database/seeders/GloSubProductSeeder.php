<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GloSubProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * @var \App\Models\Product $glo
         */
        $glo = \App\Models\Product::where('name', 'Glo Databundle')->first();
        $glo->update(['has_sub_product' => true]);

        $glo->subProducts()->create([
            'name' => '50MB (1 Day-N50)',
            'price' => 50,
            'description' => 'Day Plan',
            'up_product_key' => 'DATA-18',
        ]);

        $glo->subProducts()->create([
            'name' => '150MB (1 Day-N100)',
            'price' => 100,
            'description' => 'Day Plan',
            'up_product_key' => 'DATA-21',
        ]);

        $glo->subProducts()->create([
            'name' => '350MB (2 Days-N200)',
            'price' => 200,
            'description' => 'Day Plan',
            'up_product_key' => 'DATA-28',
        ]);

        $glo->subProducts()->create([
            'name' => '1.35GB (14 Days-N500)',
            'price' => 500,
            'description' => 'Day Plan',
            'up_product_key' => 'DATA-27',
        ]);

        $glo->subProducts()->create([
            'name' => '2.9GB (30 Days-N1000)',
            'price' => 1000,
            'description' => 'Day Plan',
            'up_product_key' => 'DATA-2',
        ]);

        $glo->subProducts()->create([
            'name' => '5.8GB (30 Days-N2000)',
            'price' => 2000,
            'description' => 'Day Plan',
            'up_product_key' => 'DATA-25',
        ]);

        $glo->subProducts()->create([
            'name' => '7.7GB (30 Days-N2500)',
            'price' => 2500,
            'description' => 'Day Plan',
            'up_product_key' => 'DATA-19',
        ]);

        $glo->subProducts()->create([
            'name' => '10GB (30 Days-N3000)',
            'price' => 3000,
            'description' => 'Day Plan',
            'up_product_key' => 'DATA-23',
        ]);

        $glo->subProducts()->create([
            'name' => '13.5GB (30 Days-N4000)',
            'price' => 4000,
            'description' => 'Day Plan',
            'up_product_key' => 'DATA-12',
        ]);

        $glo->subProducts()->create([
            'name' => '18.25GB (30 Days-N5000)',
            'price' => 5000,
            'description' => 'Day Plan',
            'up_product_key' => 'DATA-5',
        ]);

        $glo->subProducts()->create([
            'name' => '29.5GB (30 Days-N8000)',
            'price' => 8000,
            'description' => 'Day Plan',
            'up_product_key' => 'DATA-4',
        ]);

        $glo->subProducts()->create([
            'name' => '50GB (30 Days-N10000)',
            'price' => 10000,
            'description' => 'Day Plan',
            'up_product_key' => 'DATA-10',
        ]);

        $glo->subProducts()->create([
            'name' => '93GB (30 Days-N15000)',
            'price' => 15000,
            'description' => 'Day Plan',
            'up_product_key' => 'DATA-11',
        ]);

        $glo->subProducts()->create([
            'name' => '119GB (30 Days-N18000)',
            'price' => 18000,
            'description' => 'Day Plan',
            'up_product_key' => 'DATA-20',
        ]);

        $glo->subProducts()->create([
            'name' => '138GB (30 Days-N20000)',
            'price' => 20000,
            'description' => 'Day Plan',
            'up_product_key' => 'DATA-33',
        ]);


    }
    
}
