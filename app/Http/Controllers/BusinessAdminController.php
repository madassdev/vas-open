<?php

namespace App\Http\Controllers;

use App\Helpers\DBSwap;
use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\AdminBusinessDetails;
use App\Mail\UserCreatedPasswordMail;
use App\Models\Business;
use App\Models\BusinessDocumentRequest;
use App\Models\BusinessUser;
use App\Models\Role;
use App\Models\Transaction;
use App\Models\User;
use App\Services\MailApiService;
use Exception;
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

    public function generateRandomCharacters($length = 4)
    {
        $seed = str_split('abcdefghijklmnopqrstuvwxyz'
            . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
            . '0123456789!@#$%^&*()'); // and any other characters
        shuffle($seed); // probably optional since array_is randomized; this may be redundant
        $rand = '';
        foreach (array_rand($seed, $length) as $k) $rand .= $seed[$k];
        return $rand;
    }

    public function createBusiness(RegistrationRequest $request)
    {
        // Setup keys and passwords
        $generated_password = $this->generateRandomCharacters() . $this->generateRandomCharacters();
        
        // Create business
        $business = Business::updateOrCreate([
            "email" => $request->business_email,
        ], [
            "name" => $request->business_name,
            "email" => $request->business_email,
            "phone" => $request->business_phone_number,
            "address" => $request->business_address,
            "current_env" => "test",
            "live_enabled" => true,
            "business_category_id" => $request->business_category_id,
        ]);

        $business->createWallet();
        $business->test_api_key = strtoupper("pk_test_" . str()->uuid());
        $business->live_api_key = strtoupper("pk_live_" . str()->uuid());
        $business->test_secret_key = strtoupper("sk_test_" . str()->uuid());
        $business->live_secret_key = strtoupper("sk_live_" . str()->uuid());
        $business->save();
        // Create User
        $user = User::updateOrCreate([
            "email" => $request->email,
        ], [
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "email" => $request->email,
            "phone" => $request->phone_number,
            "business_id" => $business->id,
            "password" => bcrypt($generated_password),
            "verification_code" => $generated_password,
            "verified" => false,
        ]);

        // Attach business to user
        $role = Role::whereName('business_super_admin')->first();
        $user->businesses()->attach($business->id, ["is_active" => true, 'role_id' => $role->id]);

        // Assign role to user 
        $businessUser = BusinessUser::whereBusinessId($business->id)->whereUserId($user->id)->first();
        $user->assignRole('business_super_admin');
        $businessUser->assignRole('business_super_admin');

        // Create user and business on test env
        DBSwap::setConnection('mysqltest');

        $test_business = Business::updateOrCreate([
            "email" => $request->business_email,
        ], [
            "name" => $request->business_name,
            "email" => $request->business_email,
            "phone" => $request->business_phone_number,
            "address" => $request->business_address,
            "current_env" => "test",
            "test_api_key" => $business->test_api_key,
            "live_enabled" => true,
            "business_category_id" => $request->business_category_id,
        ]);
        $test_business->createWallet();
        // Create User
        $test_user = User::updateOrCreate([
            "email" => $request->email,
        ], [
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "email" => $request->email,
            "phone" => $request->phone_number,
            "business_id" => $test_business->id,
            "password" => bcrypt($generated_password),
            "verification_code" => $generated_password,
            "verified" => false,
        ]);

        $test_role = Role::whereName('business_super_admin')->first();
        // Attach business to user
        $test_user->businesses()->attach($test_business->id, ["is_active" => true, "role_id" => $test_role->id]);

        // Assign role to user 
        $testBusinessUser = BusinessUser::whereBusinessId($test_business->id)->whereUserId($test_user->id)->first();
        $test_user->assignRole('business_super_admin');
        $testBusinessUser->assignRole('business_super_admin');


        DBSwap::setConnection('mysqllive');
        // TODO: Create user on test env

        // Notify user
        $mailError = null;
        $passwordMail = new MailApiService($user->email, "[Vas Reseller] Here's your account details!", (new UserCreatedPasswordMail($user))->render());
        try {
            $passwordMail->send();
        } catch (Exception $e) {
            $mailError = $e->getMessage();
        };

        // Create response for test environments where mail may not be setup yet.
        $data = config('app.env') !== 'production' ? ["generated_password" => $generated_password, "mail_error" => $mailError] : [];

        return $this->sendSuccess('User created successfully. Please check your mail for password to proceed with requests.', $data);
    }
}
