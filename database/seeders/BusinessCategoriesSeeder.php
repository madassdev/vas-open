<?php

namespace Database\Seeders;

use App\Models\BusinessCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusinessCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $businessCategories = collect([
            "Small and Medium Scale Enterprise",
            "Online Stores",
            "Betting & Gaming",
            "Delivery & Logistics",
            "Utility Companies",
            "Insurance",
            "Government Organisations and Taxes",
            "Electricity Companies",
            "Super Agent/ MMOs",
            "Pensions",
            "NGOs",
            "Others",
            "Savings and Investment",
            "Payment Aggregator",
            "Lending",
            "Cooperative",
            "Cryptocurrency",
            "Digital Banking",
            "Educational Institutions",
            "FMCGs",
            "Forex",
            "eCommerce",
            "Bank & Microfinance Banks",
            "Fintech",
            "Health",
            "Entertainment and Social media",
            "VTU Partner Businesses",
        ]);

        $businessCategories->map(function ($category) {
            BusinessCategory::updateOrcreate([
                "name" => $category
            ], [
                "name" => $category
            ]);
        });
    }
}
