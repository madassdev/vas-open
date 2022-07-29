<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //

    public function list()
    {
        $user = auth()->user();
        return $user;
    }

    public function listCategories()
    {
        $product_categories = ProductCategory::with('products')->get();
        return $this->sendSuccess("Product categories fetched successfully", ["product_categories" => $product_categories]);
    }

    public function getProductsConfiguration()
    {
        $business = auth()->user()->business;
        $products = $business->products
            ->map(function ($p) {

                return $p->createConfigDto()->only(
                    'name',
                    'shortname',
                    'category_name',
                    'unit_cost',
                    'description',
                    'logo',
                    'enabled',
                    'service_status',
                    'deployed',
                    'min_amount',
                    'max_amount',
                    'max_quantity',
                    'configurations',
                    'commission_type',
                    'has_fee',
                    'fee_configuration',
                    'type',
                    'created_at',
                    'updated_at',
                );
            });
        return $this->sendSuccess("Products configuration fetched successfully", [
            "products" => $products,
        ]);
    }
}
