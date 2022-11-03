<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GotvSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $goTv = \App\Models\Product::where('service_type', 'gotv')->first();
        $goTv->update(['has_sub_product' => true]);

        $goTv->subProducts()->create([
            'name' => 'GOTV LITE - 900',
            'price' => 900,
            'description' => 'GOTV LITE - 900',
            'up_product_key' => 'GOLITE',
        ]);

        $goTv->subProducts()->create([
            'name' => 'GOTV MAX',
            'price' => 4150,
            'description' => 'GOTV MAX',
            'up_product_key' => 'GOTVMAX',
        ]);

        $goTv->subProducts()->create([
            'name' => 'GOTV JINJA',
            'price' => 1900,
            'description' => 'GOTV JINJA',
            'up_product_key' => 'GOTVNJ1',
        ]);

        $goTv->subProducts()->create([
            'name' => 'GOTV JOLLI',
            'price' => 1900,
            'description' => 'GOTV JOLLI',
            'up_product_key' => 'GOTVNJ2',
        ]);

        $goTv->subProducts()->create([
            'name' => 'GOTV SUPA',
            'price' => 5500,
            'description' => 'GOTV SUPA',
            'up_product_key' => 'GOTVSUPA',
        ]);

        $goTv->subProducts()->create([
            'name' => 'GOTV LITE (QUARTERLY)',
            'price' => 2400,
            'description' => 'GOTV LITE (QUARTERLY)',
            'up_product_key' => 'GOTVLITE',
        ]);

        $goTv->subProducts()->create([
            'name' => 'GOTV LITE (ANNUAL)',
            'price' => 7700,
            'description' => 'GOTV LITE (ANNUAL)',
            'up_product_key' => 'GOTVLITE',
        ]);
    }
}
