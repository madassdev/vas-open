<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StartimesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $startimes = \App\Models\Product::where('service_type', 'startimes')->first();
        $startimes->update(['has_sub_product' => true]);

        $startimes->subProducts()->create([
            'name' => 'DTT-NOVA Monthly',
            'price' => 900,
            'description' => 'Startimes DTT-NOVA Monthly',
            'up_product_key' => null
        ]);

        $startimes->subProducts()->create([
            'name' => 'DTT-BASIC Daily',
            'price' => 160,
            'description' => 'Startimes DTT-BASIC Daily',
            'up_product_key' => null
        ]);

        $startimes->subProducts()->create([
            'name' => 'DTT-BASIC Weekly',
            'price' => 600,
            'description' => 'Startimes DTT-BASIC Weekly',
            'up_product_key' => null
        ]);

        $startimes->subProducts()->create([
            'name' => 'DTT-BASIC Monthly',
            'price' => 1850,
            'description' => 'Startimes DTT-BASIC Monthly',
            'up_product_key' => null
        ]);

        $startimes->subProducts()->create([
            'name' => 'DTT-NOVA Daily',
            'price' => 90,
            'description' => 'Startimes DTT-NOVA Daily',
            'up_product_key' => null
        ]);


        $startimes->subProducts()->create([
            'name' => 'DTT-NOVA Weekly',
            'price' => 300,
            'description' => 'Startimes DTT-NOVA Weekly',
            'up_product_key' => null
        ]);

        $startimes->subProducts()->create([
            'name' => 'DTT-CLASSIC Daily',
            'price' => 320,
            'description' => 'Startimes DTT-CLASSIC Daily',
            'up_product_key' => null
        ]);

        $startimes->subProducts()->create([
            'name' => 'DTT-CLASSIC Weekly',
            'price' => 1200,
            'description' => 'Startimes DTT-CLASSIC Weekly',
            'up_product_key' => null
        ]);

        $startimes->subProducts()->create([
            'name' => 'DTT-CLASSIC Monthly',
            'price' => 2750,
            'description' => 'Startimes DTT-CLASSIC Monthly',
            'up_product_key' => null
        ]);

        $startimes->subProducts()->create([
            'name' => 'DTH-NOVA Daily',
            'price' => 90,
            'description' => 'Startimes DTH-NOVA Daily',
            'up_product_key' => null
        ]);

        $startimes->subProducts()->create([
            'name' => 'DTH-NOVA Weekly',
            'price' => 300,
            'description' => 'Startimes DTH-NOVA Weekly',
            'up_product_key' => null
        ]);

        $startimes->subProducts()->create([
            'name' => 'DTH-NOVA Monthly',
            'price' => 900,
            'description' => 'Startimes DTH-NOVA Monthly',
            'up_product_key' => null
        ]);

        $startimes->subProducts()->create([
            'name' => 'DTH-SMART Daily',
            'price' => 180,
            'description' => 'Startimes DTH-SMART Daily',
            'up_product_key' => null
        ]);

        $startimes->subProducts()->create([
            'name' => 'DTH-SMART Weekly',
            'price' => 600,
            'description' => 'Startimes DTH-SMART Weekly',
            'up_product_key' => null
        ]);

        $startimes->subProducts()->create([
            'name' => 'DTH-SMART Monthly',
            'price' => 2600,
            'description' => 'Startimes DTH-SMART Monthly',
            'up_product_key' => null
        ]);

        $startimes->subProducts()->create([
            'name' => 'DTH-SUPER Daily',
            'price' => 360,
            'description' => 'Startimes DTH-SUPER Daily',
            'up_product_key' => null
        ]);

        $startimes->subProducts()->create([
            'name' => 'DTH-SUPER Weekly',
            'price' => 1300,
            'description' => 'Startimes DTH-SUPER Weekly',
            'up_product_key' => null
        ]);

        $startimes->subProducts()->create([
            'name' => 'DTH-SUPER Monthly',
            'price' => 4900,
            'description' => 'Startimes DTH-SUPER Monthly',
            'up_product_key' => null
        ]);
    }
}
