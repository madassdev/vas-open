<?php

namespace App\Http\Controllers;

use App\Helpers\DBSwap;
use App\Models\Business;
use App\Models\BusinessUser;
use App\Models\Transaction;
use App\Services\BalanceService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class BusinessController extends Controller
{
    //

    public function switchEnv(Request $request)
    {
        $request->validate([
            "env" => "required|string|in:test,live"
        ]);
        // Perform series of checks...
        $user = auth()->user();
        $business = $user->business;
        if (strtolower($request->env) == "live") {
            $businessBank = $business->businessBank;
            if (!($businessBank && $business->bank_verified)) {
                return $this->sendError("Business Bank details must be verified before you can be enabled to go live", [], 403);
            }

            if (!$business->live_enabled) {
                return $this->sendError("[BUSINESS ENV ERROR]: Business is not enabled to toggle to live.");
            }

            if ($business->is_bank) {
                return $this->sendError("Business is a bank customer, please contact technical support", [], 403);
            }

            if (!$business->document_verified) {
                return $this->sendError("Business documents must be verified before you can be enabled to go live", [], 403);
            }

            if (!$business->merchant_id) {
                return $this->sendError("Business Merchant ID must be set before you can be enabled to go live", [], 403);
            }
            if (!$business->terminal_id) {
                return $this->sendError("Business Terminal ID must be set before you can be enabled to go live", [], 403);
            }

            if (!$business->client_id) {
                $service = new BalanceService();
                $res = $service->registerVasCustomer($business);
                if (!$res['success']) {
                    return $this->sendError($res['message'], [], 400);
                }
                $data = @$res['data'];
                $client_id = @$data['clientId'];

                if ($client_id) {
                    $business->client_id = $client_id;
                    $business->save();
                } else {
                    return $this->sendError("Unable to generate Client ID", [], 400);
                }
            }
        }

        $business->current_env = $request->env;
        $business->save();
        return $this->sendSuccess("Bussiness environment successfully switched to " . $request->env);
    }

    public function switchActiveBusiness(Request $request)
    {
        $request->validate([
            "business_id" => "required|exists:businesses,id"
        ]);
        $user = auth()->user();
        $switch = $user->switchActiveBusiness($request->business_id);
        $user->active_business_role = $user->businessUser->role;
        $user->load('businesses', 'business.businessBank', 'businessUser.role');

        return $this->sendSuccess("User Active Business switched successfully", [
            "user" => $user
        ]);
    }

    public function seed(Request $request)
    {
        DBSwap::setConnection('mysqltest');
        $amount = $request->amount ?? 1;
        $business = Business::find(1);
        $transactions = $business->createDemoTransaction($amount);
        return $transactions;
    }

    public function getLowBalanceThreshold()
    {
        $business = auth()->user()->business;
        return $this->sendSuccess("Business Low Balance Threshold Fetched successfully", [
            "low_balance_threshold" => $business->low_balance_threshold,
            "balance_notification_recipients" => $business->balance_notification_recipients,
        ]);
    }

    public function setLowBalanceThreshold(Request $request)
    {
        $request->validate([
            "low_balance_threshold" => "required|numeric|min:0",
            "balance_notification_recipients" => "required|string"
        ]);
        // $ip_addresses = collect($request->ip_addresses)->unique()->toArray();
        $comma_separated_string = str_replace(' ', '', $request->balance_notification_recipients);
        $string_to_array = explode(',', $comma_separated_string);
        $validator = Validator::make(["balance_notification_recipients" => $string_to_array], [
            "balance_notification_recipients" => "required|array",
            "balance_notification_recipients.*" => "required|email",
        ]);
        if ($validator->fails()) {
            return response()->json([
                "error" => $validator->errors()
            ], 422);
        }
        $business = auth()->user()->business;
        $business->low_balance_threshold = $request->low_balance_threshold;
        $business->balance_notification_recipients = $request->balance_notification_recipients;
        $business->save();
        return $this->sendSuccess("Business Low Balance Threshold Updated successfully", [
            "low_balance_threshold" => $business->low_balance_threshold,
            "balance_notification_recipients" => $business->balance_notification_recipients,
        ]);
    }

    public function getWebhookUrl()
    {
        $business = auth()->user()->business;
        return $this->sendSuccess("Business Webhook Url Fetched successfully", [
            "webhook" => $business->webhook,
        ]);
    }

    public function setWebhookUrl(Request $request)
    {
        $request->validate([
            "webhook_url" => "required|url"
        ]);
        $business = auth()->user()->business;
        $business->webhook = $request->webhook_url;
        $business->save();
        return $this->sendSuccess("Business Webhook Url Updated successfully", [
            "webhook" => $business->webhook,
        ]);
    }

    public function getWhitelistIps()
    {
        $business = auth()->user()->business;
        // return $business->users->pluck('id');
        return $this->sendSuccess("Business Whitelisted Ips fetched successfully", [
            "ip_addresses" => $business->ip_addresses,
        ]);
    }

    public function setWhitelistIps(Request $request)
    {
        $request->validate([
            "ip_addresses" => "required|string",
        ]);

        // $request->validate([
        //     "ip_addresses" => "required|array",
        //     "ip_addresses.*" => "required|ipv4",
        // ]);

        // $ip_addresses = collect($request->ip_addresses)->unique()->toArray();
        $comma_separated_addresses = str_replace(' ', '', $request->ip_addresses);
        $addresses_to_array = explode(',', $comma_separated_addresses);
        $validator = Validator::make(["ip_addresses" => $addresses_to_array], [
            "ip_addresses" => "required|array",
            "ip_addresses.*" => "required|ipv4",
        ]);
        if ($validator->fails()) {
            return response()->json([
                "error" => $validator->errors()
            ], 422);
        }

        $business = auth()->user()->business;
        $business->ip_addresses = $comma_separated_addresses;
        $business->save();
        return $this->sendSuccess("Business Whitelisted Ips updated successfully", [
            "ip_addresses" => $business->ip_addresses ?? [],
        ]);
    }

    public function toggleBusinessNotification()
    {
        $user = auth()->user();
        $businessUser = BusinessUser::whereUserId($user->id)
            ->whereBusinessId($user->business_id)
            ->first();
        $businessUser->notify = !$businessUser->notify;
        $businessUser->save();
        $user->load('businesses', 'business.businessBank', 'businessUser');
        return $this->sendSuccess('Business User Notification Toggled Successfully', [
            "user" => $user,
        ]);
        return $businessUser;
    }

    public function resetKeys(Request $request)
    {
        $request->validate([
            "key_type" => "required|string|in:test_api_key,live_api_key,test_secret_key,live_secret_key"
        ]);
        // Can user perform this action?
        $user = auth()->user();
        $business = $user->business;
        $businessUser = BusinessUser::whereBusinessId($business->id)->whereUserId($user->id)->first();
        // Does this user actually still have this business under them?
        if (!$businessUser) {
            return $this->sendError('We could not find this business for this user.', [], 403);
        }
        // Is this business the current active business of this user?       
        if (!$businessUser->is_active) {
            return $this->sendError('This is not the current active business of this user. Please update active business first.', [], 403);
        }
        switch ($request->key_type) {
            case 'test_api_key':
                $business->test_api_key = strtoupper("pk_test_" . str()->uuid());
                break;
            case 'live_api_key':
                $business->live_api_key = strtoupper("pk_live_" . str()->uuid());
                break;
            case 'test_secret_key':
                $business->test_secret_key = strtoupper("sk_test_" . str()->uuid());
                break;
            case 'live_secret_key':
                $business->live_secret_key = strtoupper("sk_live_" . str()->uuid());
                break;
            default:
                # code...
                break;
        }

        $business->save();

        // Update test db
        DBSwap::setConnection('mysqltest');
        $test_business = Business::whereEmail($business->email)->first();
        $test_business->test_secret_key = $business->test_secret_key;
        $test_business->test_api_key = $business->test_api_key;
        $test_business->live_api_key = $business->live_api_key;
        $test_business->live_secret_key = $business->live_secret_key;
        $test_business->save();
        DBSwap::setConnection('mysqllive');


        return $this->sendSuccess($request->key_type . " has been reset successfully.", [
            "business" => $business
        ]);
    }

    public function getProducts(Request $request)
    {
        $business = auth()->user()->business;
        $query = $business->products();
        if ($request->product_name) {
            $query = $query->whereName($request->product_name);
        }
        if ($request->product_shortname) {
            $query = $query->whereName($request->product_shortname);
        }

        if ($request->biller_name) {
            $biller_name = $request->biller_name;
            $query = $query->whereHas('biller', function ($q) use ($biller_name) {
                $q->where('name', '=', $biller_name);
            });
        }

        if ($request->category_name) {
            $category_name = $request->category_name;
            $query = $query->whereHas('productCategory', function ($q) use ($category_name) {
                $q->where('name', '=', $category_name);
            });
        }

        if ($request->category_id) {
            $category_id = $request->category_id;
            $query = $query->whereHas('productCategory', function ($q) use ($category_id) {
                $q->where('id', '=', $category_id);
            });
        }
        $products = $query->with('productCategory', 'biller')->get();
        return $this->sendSuccess("Business Products fetched successfully", ["products" => $products]);
    }
    public function getBalance(BalanceService $balanceService)
    {
        // @TODO: Sort balance threshold logic
        $business = auth()->user()->business;
        $env = $business->current_env;
        $balance = 0;
        try {
            $balance = $balanceService->getBalance($business->client_id ?? '00');
        } catch (\Exception $e) {
            $balance = 'Balance not available';
        }
        $live_stats = [
            "wallet_balance" => $balance,
            "transactions" => [
                "failed_percentage" => 0,
                "success_percentage" => 0,
                "pending_percentage" => 0,
            ],
            "total_commission_earned" => 0,
            "total_fees_paid" => 0,
            "recent_transactions" => 0,
            "transactions_count" => 0,
            "transactions_volume" => 0,
        ];
        $test_stats = [
            "wallet_balance" => 1000,
            "transactions" => [
                "failed_percentage" => 8,
                "success_percentage" => 80,
                "pending_percentage" => 12,
            ],
            "total_commission_earned" => 140,
            "total_fees_paid" => 23,
            "recent_transactions" => Transaction::latest()->take(rand(1, 5))->get(),
            "transactions_count" => rand(5, 20),
            "transactions_volume" => rand(2000, 10000),
        ];

        $stats = $env == "live" ? $live_stats : $test_stats;
        $recent_transactions = Transaction::with('product.productCategory', 'product.biller')->whereBusinessId($business->id)->latest()->take(5)->get();
        if (auth()->user()->email != "oluwaseunoffice@gmail.com") {
            $stats = $live_stats;
        }

        return $this->sendSuccess("Stats fetched successfully!", ["stats" => $stats, "recent_transactions" => $recent_transactions]);;
    }

    // 1. Percentage of failed, pending and successful transaction 
    // 2. Wallet balance 
    // 3. Total commission earned 
    // 4. Total fees paid 
    // 5. Recent transactions 
    // 6. Count of transactions 
    // 7. Volume of transactions 
    // 8. Filter per product 
    // 9. Date range filter 
}
