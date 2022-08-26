<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    //
    public function index()
    {
        $product_categories = ProductCategory::with('products')->get();

        return $this->sendSuccess("Product Categories fetched successfully", [
            "product_categories" => $product_categories
        ]);
    }

    public function show(ProductCategory $product_category)
    {
        $product_category->load('products');
        return $this->sendSuccess("Product Category fetched successfully", ["product_category" => $product_category]);
    }

    public function update(Request $request, ProductCategory $product_category)
    {
        $request->validate([
            "name" => "required|sometimes|string",
        ]);

        $product_category->update($request->all());

        return $this->sendSuccess("Product Category updated successfully", [
            "product_category" => $product_category->load('products')
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string|unique:business_categories,name",
        ]);

        $product_category = ProductCategory::create([
            "name" => $request->name,
        ]);

        return $this->sendSuccess("Product Category created successfully", [
            "product_category" => $product_category->load('products')
        ]);
    }



    public function destroy(ProductCategory $product_category)
    {
        $product_category->delete();
        return $this->sendSuccess("Product Category deleted successfully", []);
    }
}
