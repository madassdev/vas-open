<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productCategories = [
            "Telco Top Up Services",
            "Databundle Services",
            "Electricity Services",
            "Cable Tv Services",
            "Insurance Services",
            "Pin Services",
            "Collection Services",
            "Validation Services",
            "Education Services",
            "Internet Services",
        ];

        // $productCategories->map(function ($category) {
        //     ProductCategory::updateOrcreate([
        //         "name" => $category
        //     ], [
        //         "name" => $category
        //     ]);
        // });
        foreach ($productCategories as $index=>$category) {
            ProductCategory::create([
                "name" => $category,
                "id" => $index+1,
                "implementation_class" => explode(" ", $category)[0],
                "shortname" => Str::lower(explode(" ", $category)[0]),
            ]);
        }
        //
    }
}
