<?php

namespace App\Http\Controllers;

use App\Models\BusinessCategory;
use Illuminate\Http\Request;

class BusinessCategoryController extends Controller
{
    //
    public function list()
    {
        $business_categories = BusinessCategory::all();
        return $this->sendSuccess("Business categories fetched successfully", ["business_categories" => $business_categories]);
    }

    public function index()
    {
        $business_categories = BusinessCategory::all();

        return $this->sendSuccess("Business Categories fetched successfully", [
            "business_categories" => $business_categories
        ]);
    }

    public function show(BusinessCategory $business_category)
    {
        return $this->sendSuccess("Business Category fetched successfully", ["business_category" => $business_category]);
    }

    public function update(Request $request, BusinessCategory $business_category)
    {
        $request->validate([
            "name" => "required|sometimes|string",
        ]);

        $business_category->update($request->all());

        return $this->sendSuccess("Business Category updated successfully", [
            "business_category" => $business_category
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string|unique:business_categories,name",
        ]);

        $business_category = BusinessCategory::create([
            "name" => $request->name,
        ]);

        return $this->sendSuccess("Business Category created successfully", [
            "business_category" => $business_category
        ]);
    }

    

    public function destroy(BusinessCategory $business_category)
    {
        $business_category->delete();
        return $this->sendSuccess("Business Category deleted successfully", []);
    }
}
