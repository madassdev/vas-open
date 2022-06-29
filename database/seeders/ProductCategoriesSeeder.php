<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productCategories = collect([
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
        ]);

        $productCategories->map(function ($category) {
            ProductCategory::updateOrcreate([
                "name" => $category
            ], [
                "name" => $category
            ]);
        });
        //
    }
}
