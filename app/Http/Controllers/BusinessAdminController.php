<?php

namespace App\Http\Controllers;

use App\Http\Resources\AdminBusinessDetails;
use App\Models\Business;
use App\Models\BusinessDocumentRequest;
use App\Models\Transaction;
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
        return substr($key, 0, 12) . "*******" . substr($key, $total - 6, 6);
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
        $recent_transactions = Transaction::with('product.productCategory', 'product.biller')->whereBusinessId($business->id)->latest()->take(5)->get();
        $business->recent_transactions = $recent_transactions;
        $business = new AdminBusinessDetails(

            $business->load('users', 'products', 'businessDocument.businessDocumentRequests', 'businessBank', 'invitees')
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
            "business_document" => $business->businessDocument->load("businessDocumentRequests"),
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

    public function approveBusinessDocuments($business_document_request_id, Request $request)
    {
        $user = auth()->user();
        $request->validate([
            "action" => "required|in:approve,reject,pending"
        ]);
        $document_request = BusinessDocumentRequest::find($business_document_request_id);

        if (!$document_request) {
            return $this->sendError("Business Document Request not found with that id", [], 404);
        }
        $business = $document_request->business;
        $document_request->user_id = $user->id;

        // if ($document_request->status !== "pending") {
        //     return $this->sendError("Business Document Request has been treated and is not pending", [], 403);
        // }

        if ($request->action === "approve") {
            // Notify
            $document_request->status = "successful";
            $business->enabled = true;
            $business->live_enabled = true;
            $business->document_verified = true;
            $business->save();
            $document_request->save();
            return $this->sendSuccess("Business document approved successfully", [
                "business" => $business->load('businessDocument.businessDocumentRequests'),
            ]);
        }
        if ($request->action === "reject") {
            // Notify
            $request->validate([
                "comment" => "requried|max:500"
            ]);
            $document_request->status = "failed";
            $document_request->comment = $request->comment;
            $business->enabled = false;
            $business->live_enabled = false;
            $business->document_verified = false;
            $business->save();
            $document_request->save();
            return $this->sendSuccess("Business document rejected successfully", [
                "business" => $business->load('businessDocument.businessDocumentRequests'),
            ]);
        }
        if ($request->action === "pending") {
            $document_request->status = "pending";
            $business->enabled = false;
            $business->live_enabled = false;
            $business->document_verified = false;
            $business->save();
            $document_request->save();
            return $this->sendSuccess("Business document successfully marked as pending", [
                "business" => $business->load('businessDocument.businessDocumentRequests'),
            ]);
        }
    }
}
