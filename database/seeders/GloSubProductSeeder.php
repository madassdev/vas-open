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


        $glo->subProducts()->create([
            'name' => 'Voucher On SMS (VOS)',
            'price' => 0,
            'description' => 'Voucher On SMS (VOS)',
            'up_product_key' => '2',
        ]);

        $glo->subProducts()->create([
            'name' => 'Virtual Top-Up (VTU)',
            'price' => 0,
            'description' => 'Virtual Top-Up (VTU)',
            'up_product_key' => '3',
        ]);

        $glo->subProducts()->create([
            'name' => '93GB (30 Days-N15000)',
            'price' => 15000,
            'description' => '93GB (30 Days-N15000)',
            'up_product_key' => 'DATA-11',
        ]);

        $glo->subProducts()->create([
            'name' => '7GB (Special 1500)',
            'price' => 1500,
            'description' => '7GB (Special 1500)',
            'up_product_key' => 'DATA-24',
        ]);

        $glo->subProducts()->create([
            'name' => '7.7GB (30 Days-N2500)',
            'price' => 2500,
            'description' => '7.7GB (30 Days-N2500)',
            'up_product_key' => 'DATA-19',
        ]);

        $glo->subProducts()->create([
            'name' => '675GB (GloMega75000)',
            'price' => 75000,
            'description' => '675GB (GloMega75000)',
            'up_product_key' => 'DATA-68',
        ]);

        $glo->subProducts()->create([
            'name' => '525GB (GloMega60000)',
            'price' => 60000,
            'description' => '525GB (GloMega60000)',
            'up_product_key' => 'DATA-67',
        ]);

        $glo->subProducts()->create([
            'name' => '50MB (1 Day-N50)',
            'price' => 50,
            'description' => '50MB (1 Day-N50)',
            'up_product_key' => 'DATA-18',
        ]);

        $glo->subProducts()->create([
            'name' => '50GB (30 Days-N10000)',
            'price' => 10000,
            'description' => '50GB (30 Days-N10000)',
            'up_product_key' => 'DATA-10',
        ]);

        $glo->subProducts()->create([
            'name' => '500MB (WTF_N100 500MB)',
            'price' => 100,
            'description' => '500MB (WTF_N100 500MB)',
            'up_product_key' => 'DATA-802',
        ]);

        $glo->subProducts()->create([
            'name' => '500MB (Night_50)',
            'price' => 50,
            'description' => '500MB (Night_50)',
            'up_product_key' => 'DATA-30',
        ]);

        $glo->subProducts()->create([
            'name' => '5.8GB (30 Days-N2000)',
            'price' => 2000,
            'description' => '5.8GB (30 Days-N2000)',
            'up_product_key' => 'DATA-25',
        ]);

        $glo->subProducts()->create([
            'name' => '425GB (GloMega50000)',
            'price' => 50000,
            'description' => '425GB (GloMega50000)',
            'up_product_key' => 'DATA-66',
        ]);

        $glo->subProducts()->create([
            'name' => '4.1GB (30 Days-N1500)',
            'price' => 1500,
            'description' => '4.1GB (30 Days-N1500)',
            'up_product_key' => 'DATA-16',
        ]);

        $glo->subProducts()->create([
            'name' => '1.25GB (Sunday_200)',
            'price' => 200,
            'description' => '1.25GB (Sunday_200)',
            'up_product_key' => 'DATA-37',
        ]);

        $glo->subProducts()->create([
            'name' => '1.35GB (14 Days-N500)',
            'price' => 500,
            'description' => '1.35GB (14 Days-N500)',
            'up_product_key' => 'DATA-27',
        ]);

        $glo->subProducts()->create([
            'name' => '100MB (WTF_N25 100MB)',
            'price' => 25,
            'description' => '100MB (WTF_N25 100MB)',
            'up_product_key' => 'DATA-800',
        ]);

        $glo->subProducts()->create([
            'name' => '10GB (30 Days-N3000)',
            'price' => 3000,
            'description' => '10GB (30 Days-N3000)',
            'up_product_key' => 'DATA-23',
        ]);

        $glo->subProducts()->create([
            'name' => '119GB (30 Days-N18000)',
            'price' => 18000,
            'description' => '119GB (30 Days-N18000)',
            'up_product_key' => 'DATA-20',
        ]);

        $glo->subProducts()->create([
            'name' => '13.5GB (30 Days-N4000)',
            'price' => 4000,
            'description' => '13.5GB (30 Days-N4000)',
            'up_product_key' => 'DATA-12',
        ]);

        $glo->subProducts()->create([
            'name' => '138GB (30 Days-N20000)',
            'price' => 20000,
            'description' => '138GB (30 Days-N20000)',
            'up_product_key' => 'DATA-33',
        ]);

        $glo->subProducts()->create([
            'name' => '150MB (1 Day-N100)',
            'price' => 100,
            'description' => '150MB (1 Day-N100)',
            'up_product_key' => 'DATA-21',
        ]);

        $glo->subProducts()->create([
            'name' => '18.25GB (30 Days-N5000)',
            'price' => 5000,
            'description' => '18.25GB (30 Days-N5000)',
            'up_product_key' => 'DATA-5',
        ]);

        $glo->subProducts()->create([
            'name' => '1GB (Night_100)',
            'price' => 100,
            'description' => '1GB (Night_100)',
            'up_product_key' => 'DATA-31',
        ]);

        $glo->subProducts()->create([
            'name' => '1TB (GloMega100000)',
            'price' => 100000,
            'description' => '1TB (GloMega100000)',
            'up_product_key' => 'DATA-69',
        ]);

        $glo->subProducts()->create([
            'name' => '2.9GB (30 Days-N1000)',
            'price' => 1000,
            'description' => '2.9GB (30 Days-N1000)',
            'up_product_key' => 'DATA-2',
        ]);

        $glo->subProducts()->create([
            'name' => '200MB (WTF_N50 200MB)',
            'price' => 50,
            'description' => '200MB (WTF_N50 200MB)',
            'up_product_key' => 'DATA-801',
        ]);

        $glo->subProducts()->create([
            'name' => '20MB (TelegramN25 20MB)',
            'price' => 25,
            'description' => '20MB (TelegramN25 20MB)',
            'up_product_key' => 'DATA-803',
        ]);

        $glo->subProducts()->create([
            'name' => '225GB (GloMega30000)',
            'price' => 30000,
            'description' => '225GB (GloMega30000)',
            'up_product_key' => 'DATA-64',
        ]);

        $glo->subProducts()->create([
            'name' => '250MB (Night_25)',
            'price' => 25,
            'description' => '250MB (Night_25)',
            'up_product_key' => 'DATA-15',
        ]);

        $glo->subProducts()->create([
            'name' => '350MB (2 Days-N200)',
            'price' => 200,
            'description' => '350MB (2 Days-N200)',
            'up_product_key' => 'DATA-28',
        ]);

        $glo->subProducts()->create([
            'name' => '300GB (GloMega36000)',
            'price' => 36000,
            'description' => '300GB (GloMega36000)',
            'up_product_key' => 'DATA-65',
        ]);

        $glo->subProducts()->create([
            'name' => '29.5GB (30 Days-N8000)',
            'price' => 8000,
            'description' => '29.5GB (30 Days-N8000)',
            'up_product_key' => 'DATA-4',
        ]);



    }
    
}
