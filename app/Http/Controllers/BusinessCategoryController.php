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
}
