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
        $products = $business->products;
        // ->map(function($p){
            
        //     $custom_commission = $p->pivot->commission_value;
        //     return $custom_commission;
        //     $commission_config = [
        //         "provider_commsision_value" => $p->provider_commission_value,
        //     ];
        //     return [
        //         "name"=>$p->name,
        //         "shortname"=>$p->shortname,
        //         "unit_cost"=>$p->unit_cost,
        //         "biller"=>$p->biller,
        //         "product_code" => $p->product_code,
        //         "min_amount" => $p->min_amount,
        //         "max_amount" => $p->max_amount,
        //         "max_quantity" => $p->max_quantity,
        //         "commission_type" => $p->commission_type,
        //     ]+$commission_config;
        // });
        return $products;
    }
}
