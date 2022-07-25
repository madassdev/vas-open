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
        $product_categories = ProductCategory::all();
        return $this->sendSuccess("Product categories fetched successfully", ["product_categories" => $product_categories]);
    }
}
