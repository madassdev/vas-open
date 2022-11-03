<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DSTVSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $dstv = \App\Models\Product::where('service_type', 'dstv')->first();
        $dstv->update(['has_sub_product' => true]);

        $dstv->subProducts()->create([
            'name' => 'DSTV Compact',
            'price' => 9000,
            'description' => 'DSTV Compact',
            'up_product_key' => 'COMPE36',
        ]);

        $dstv->subProducts()->create([
            'name' => 'DSTV Compact Plus',
            'price' => 14250,
            'description' => 'DSTV Compact Plus',
            'up_product_key' => 'COMPLE36',
        ]);

        $dstv->subProducts()->create([
            'name' => 'DSTV Premium',
            'price' => 21000,
            'description' => 'DSTV Premium',
            'up_product_key' => 'PRWE36',
        ]);

        $dstv->subProducts()->create([
            'name' => 'DSTV Premium Asia',
            'price' => 26400,
            'description' => 'DSTV Premium Asia',
            'up_product_key' => 'PRWASIE36_HDPVRE36',
        ]);

        $dstv->subProducts()->create([
            'name' => 'DSTV Asia StandAlone',
            'price' => 7500,
            'description' => 'DSTV Asia StandAlone',
            'up_product_key' => 'ASIAE36',
        ]);

        $dstv->subProducts()->create([
            'name' => 'DSTV YANGA -  2950',
            'price' => 2950,
            'description' => 'DSTV YANGA -  2950',
            'up_product_key' => 'NNJ1E36',
        ]);

        $dstv->subProducts()->create([
            'name' => 'DSTV CONFAM -  5300',
            'price' => 5300,
            'description' => 'DSTV CONFAM -  5300',
            'up_product_key' => 'NNJ2E36',
        ]);

        $dstv->subProducts()->create([
            'name' => 'DSTV YANGA -  2150',
            'price' => 2150,
            'description' => 'DSTV YANGA -  2150',
            'up_product_key' => 'NLTESE36',
        ]);

        $dstv->subProducts()->create([
            'name' => 'DSTV GREAT WALL -  1285',
            'price' => 1285,
            'description' => 'DSTV GREAT WALL -  1285',
            'up_product_key' => 'GWALLE36',
        ]);

        $dstv->subProducts()->create([
            'name' => 'DSTV COMPACT + XTRAVIEW - 11900',
            'price' => 11900,
            'description' => 'DSTV COMPACT + XTRAVIEW - 11900',
            'up_product_key' => 'COMPE36_HDPVRE36',
        ]);

        $dstv->subProducts()->create([
            'name' => 'COMPACT PLUS + ASIA - 21350',
            'price' => 21350,
            'description' => 'COMPACT PLUS + ASIA - 21350',
            'up_product_key' => 'COMPLE36_ASIADDE36',
        ]);

        $dstv->subProducts()->create([
            'name' => 'COMPACT PLUS + FRENCH PLUS - 23550',
            'price' => 23550,
            'description' => 'COMPACT PLUS + FRENCH PLUS - 23550',
            'up_product_key' => 'COMPLE36_FRN15E36',
        ]);

        $dstv->subProducts()->create([
            'name' => 'COMPACT PLUS + FRENCH TOUCH - 11650',
            'price' => 11650,
            'description' => 'COMPACT PLUS + FRENCH TOUCH - 11650',
            'up_product_key' => 'COMPLE36_FRN7E36',
        ]);

        $dstv->subProducts()->create([
            'name' => 'COMPACT PLUS + XTRAVIEW - 17150',
            'price' => 17150,
            'description' => 'COMPACT PLUS + XTRAVIEW - 17150',
            'up_product_key' => 'COMPLE36_HDPVRE36',
        ]);

        $dstv->subProducts()->create([
            'name' => 'DSTV REMIUM + FRENCH PLUS ADD ON - 25550',
            'price' => 25550,
            'description' => 'DSTV REMIUM + FRENCH PLUS ADD ON - 25550',
            'up_product_key' => null,
        ]);

        $dstv->subProducts()->create([
            'name' => 'DSTV REMIUM + FRENCH TOUCH ADD ON - 20700',
            'price' => 20700,
            'description' => 'DSTV REMIUM + FRENCH TOUCH ADD ON - 20700',
            'up_product_key' => 'PRWE36_FRN7E36',
        ]);

        $dstv->subProducts()->create([
            'name' => 'DSTV PADI + XTRAVIEW - 5050',
            'price' => 5050,
            'description' => 'DSTV PADI + XTRAVIEW - 5050',
            'up_product_key' => 'NLTESE36_HDPVRE36',
        ]);

        $dstv->subProducts()->create([
            'name' => 'DSTV YANGA + XTRAVIEW - 5850',
            'price' => 5850,
            'description' => 'DSTV YANGA + XTRAVIEW - 5850',
            'up_product_key' => 'NNJ1E36_HDPVRE36',
        ]);

        $dstv->subProducts()->create([
            'name' => 'DSTV  CONFAM + XTRAVIEW - 8200',
            'price' => 8200,
            'description' => 'DSTV  CONFAM + XTRAVIEW - 8200',
            'up_product_key' => 'NNJ2E36_HDPVRE36',
        ]);

        $dstv->subProducts()->create([
            'name' => 'DSTV PREMIUM ASIA - 23500',
            'price' => 23500,
            'description' => 'DSTV PREMIUM ASIA - 23500',
            'up_product_key' => 'PRWASIE36',
        ]);

        $dstv->subProducts()->create([
            'name' => 'DSTV PREMIUM + EXTRA VIEW - 23900',
            'price' => 23900,
            'description' => 'DSTV PREMIUM + EXTRA VIEW - 23900',
            'up_product_key' => 'PRWE36_HDPVRE36',
        ]);

        $dstv->subProducts()->create([
            'name' => 'DSTV PREMIUM + FRENCH  - 29300',
            'price' => 29300,
            'description' => 'DSTV PREMIUM + FRENCH - 29300',
            'up_product_key' => 'PRWFRNSE36',
        ]);

        $dstv->subProducts()->create([
            'name' => 'DSTV PREMIUM + FRENCH + XTRAVIEW - 32000	',
            'price' => 32000,
            'description' => 'DSTV PREMIUM + FRENCH XTRAVIEW - 32000',
            'up_product_key' => 'PRWFRNSE36_HDPVRE36',
        ]);

        $dstv->subProducts()->create([
            'name' => 'DSTV COMPACT PLUS + ASIA + XTRAVIEW- 24250',
            'price' => 24250,
            'description' => 'DSTV COMPACT PLUS + ASIA + XTRAVIEW- 24250',
            'up_product_key' => 'COMPLE36_ASIADDE36_HDPVRE36',
        ]);

        $dstv->subProducts()->create([
            'name' => 'DSTV COMPACT PLUS + FRENCH PLUS + XTRAVIEW - 26450',
            'price' => 26450,
            'description' => 'DSTV COMPACT PLUS + FRENCH PLUS + XTRAVIEW - 26450',
            'up_product_key' => 'COMPLE36_FRN15E36_HDPVRE36',
        ]);

        $dstv->subProducts()->create([
            'name' => 'DSTV COMPACT + ASIA - 16100',
            'price' => 16100,
            'description' => 'DSTV COMPACT + ASIA - 16100',
            'up_product_key' => 'COMPE36_ASIADDE36',
        ]);

        $dstv->subProducts()->create([
            'name' => 'DSTV COMPACT + FRENCH + XTRAVIEW - 14550',
            'price' => 14550,
            'description' => 'DSTV COMPACT + FRENCH + XTRAVIEW - 14550',
            'up_product_key' => 'COMPE36_FRN7E36_HDPVRE36',
        ]);

        $dstv->subProducts()->create([
            'name' => 'DSTV COMPACT + ASIA + XTRAVIEW - 19000',
            'price' => 19000,
            'description' => 'DSTV COMPACT + ASIA + XTRAVIEW - 19000',
            'up_product_key' => 'COMPE36_ASIADDE36_HDPVRE36',
        ]);

        $dstv->subProducts()->create([
            'name' => 'DSTV COMPACT + FRENCHPLUS - 18300',
            'price' => 18300,
            'description' => 'DSTV COMPACT + FRENCHPLUS - 18300',
            'up_product_key' => 'COMPE36_FRN15E36',
        ]);

        $dstv->subProducts()->create([
            'name' => 'DSTV HDPVR ACCESS SERVICE E36 - 2900',
            'price' => 2900,
            'description' => 'DSTV HDPVR ACCESS SERVICE E36 - 2900',
            'up_product_key' => 'HDPVRE36',
        ]);

        $dstv->subProducts()->create([
            'name' => 'DSTV FRENCH PLUS E36 - 9300',
            'price' => 9300,
            'description' => 'DSTV FRENCH PLUS E36 - 9300',
            'up_product_key' => 'FRN15E36',
        ]);

        $dstv->subProducts()->create([
            'name' => 'DSTV ASIAN E36 - 7100',
            'price' => 7100,
            'description' => 'DSTV ASIAN E36 - 7100',
            'up_product_key' => 'ASIADDE36',
        ]);

        $dstv->subProducts()->create([
            'name' => 'FRENCH TOUCH - 2650',
            'price' => 2650,
            'description' => 'FRENCH TOUCH - 2650',
            'up_product_key' => 'FRN7E36',
        ]);

        $dstv->subProducts()->create([
            'name' => 'XTRAVIEW ACCESS- 2900',
            'price' => 2900,
            'description' => 'XTRAVIEW ACCESS- 2900',
            'up_product_key' => 'HDPVRE36',
        ]);

        $dstv->subProducts()->create([
            'name' => 'GREAT WALL STANDALONE - 1725',
            'price' => 1725,
            'description' => 'GREAT WALL STANDALONE - 1725',
            'up_product_key' => 'GWALLE36',
        ]);

        $dstv->subProducts()->create([
            'name' => '11 BOUQUET E36 - 4100',
            'price' => 4100,
            'description' => '11 BOUQUET E36 - 4100',
            'up_product_key' => 'FRN11E36',
        ]);

        $dstv->subProducts()->create([
            'name' => 'BOX OFFICE',
            'price' => 1100,
            'description' => 'BOX OFFICE',
            'up_product_key' => null
        ]);
    }
}
