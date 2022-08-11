<?php

namespace App\Http\Controllers;

use App\Http\Resources\AdminBusinessDetails;
use App\Models\Business;
use Illuminate\Http\Request;

class BusinessAdminController extends Controller
{
    //
    public function getBusinesses(Request $request)
    {
        $per_page = $request->per_page ?? 10;
        $businesses = Business::paginate($per_page)->appends(request()->query());
        return $this->sendSuccess("Businesses fetched successful", [
            "businesses" => $businesses
        ]);
    }

    public function maskKey($key)
    {
        $total = strlen($key);
        return substr($key,0,12)."*******".substr($key, $total-6,6);
    }

    public function getBusinessDetails($business_id)
    {
        $business = Business::find($business_id);
        if (!$business) {
            return $this->sendError("Business not found with that id", [], 404);
        }

        $business->test_api_key = $this->maskKey($business->test_api_key);
        $business->live_api_key = $this->maskKey($business->live_api_key);
        $business->test_secret_key = $this->maskKey($business->test_secret_key);
        $business->live_secret_key = $this->maskKey($business->live_secret_key);
        $business = new AdminBusinessDetails(

            $business->load('users', 'products', 'businessDocument', 'businessBank', 'invitees')
        );

        return $this->sendSuccess("Business details fetched successfully", [
            "business" => $business
        ]);
    }

    public function getBusinessDocuments($business_id)
    {
        $business = Business::find($business_id);
        if (!$business) {
            return $this->sendError("Business not found with that id", [], 404);
        }

        return $this->sendSuccess("Business documents fetched successfully", [
            // "business" => $business,
            "business_document" => $business->businessDocument,
            "document_status" => $business->document_verified ? true : false,
        ]);
    }

    public function getBusinessUsers($business_id)
    {
        $business = Business::find($business_id);
        if (!$business) {
            return $this->sendError("Business not found with that id", [], 404);
        }

        return $this->sendSuccess("Business Users fetched successfully", [
            // "business" => $business,
            "business_users" => $business->users
        ]);
    }

    public function getBusinessProducts($business_id)
    {
        $business = Business::find($business_id);
        if (!$business) {
            return $this->sendError("Business not found with that id", [], 404);
        }

        $products = $business->products
            ->map(function ($p) {
                return $p->createConfigDto()
                    // ->only(
                    //     'name',
                    //     'shortname',
                    //     'category_name',
                    //     'unit_cost',
                    //     'description',
                    //     'logo',
                    //     'enabled',
                    //     'service_status',
                    //     'deployed',
                    //     'min_amount',
                    //     'max_amount',
                    //     'max_quantity',
                    //     'configurations',
                    //     'commission_type',
                    //     'has_fee',
                    //     'fee_configuration',
                    //     'type',
                    //     'created_at',
                    //     'updated_at',
                    // )
                ;
            });
        return $this->sendSuccess("Business products fetched successfully", [
            "business_products" => $products,
        ]);
    }

    public function approveBusinessDocuments($business_id)
    {
        $business = Business::find($business_id);
        if (!$business) {
            return $this->sendError("Business not found with that id", [], 404);
        }

        $business->enabled = true;
        $business->live_enabled = true;
        $business->document_verified = true;

        $business->save();
        return $this->sendSuccess("Business document approved successfully", [
            "business" => $business->load('businessDocument'),
        ]);
    }
}
