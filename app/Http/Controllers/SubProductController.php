<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SubProduct;
use Illuminate\Http\Request;

class SubProductController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            "product_id" => "required|exists:products,id",
            "name" => "required|string|max:255",
            "up_product_key" => "required|unique:sub_products,up_product_key|string|max:255",
            "description" => "string",
            "price" => "required|numeric",
        ]);

        $product = Product::find($request->product_id);
        $sub_product = $product->subProducts()->create([
            "up_product_key" => $request->up_product_key,
            "name" => $request->name,
            "description" => $request->description,
            "price" => $request->price,
        ]);

        return $this->sendSuccess("Subproduct created successfully", [
            "sub_product" => $sub_product
        ]);
    }

    public function show(SubProduct $sub_product)
    {
        return $this->sendSuccess("Subproduct fetched successfully", [
            "sub_product" => $sub_product->load('product')
        ]);
    }

    public function index(Request $request)
    {
        $per_page = $request->per_page ?? 20;
        $sub_products = SubProduct::with('product')->latest()->paginate($per_page);
        return $this->sendSuccess("Subproducts fetched successfully", [
            "sub_products" => $sub_products
        ]);
    }

    public function update(Request $request, SubProduct $sub_product)
    {
        $request->validate([
            "product_id" => "required|sometimes|exists:products,id",
            "name" => "required|sometimes|string|max:255",
            "up_product_key" => "required|sometimes|string|max:255|unique:sub_products,up_product_key," . $sub_product->id,
            "description" => "string",
            "price" => "required|sometimes|numeric",
        ]);

        $sub_product->update([
            "product_id" => $request->product_id,
            "up_product_key" => $request->up_product_key,
            "name" => $request->name,
            "description" => $request->description,
            "price" => $request->price,
        ]);

        return $this->sendSuccess("Subproduct updated successfully", [
            "sub_product" => $sub_product
        ]);
    }

    public function destroy(SubProduct $sub_product)
    {
        $sub_product->delete();
        return $this->sendSuccess("Subproduct deleted successfully", []);
    }
}
