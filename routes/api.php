<?php

use App\Helpers\DBSwap;
use App\Http\Controllers\ActionRequestController;
use App\Http\Controllers\AdminTransactionController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\BillerController;
use App\Http\Controllers\BusinessAdminController;
use App\Http\Controllers\BusinessCategoryController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\BusinessDocumentController;
use App\Http\Controllers\InviteeController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubProductController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\TransactionController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// The app uses 2 different authentication mechanisms for different environments 
// but uses same implementation logic, so we can call always do something like
// auth()->user()->business in both environments to determine the data 
// to work our logic on. On Test, we use an apiKey middleware to 
// determine the current user, while we use auth:sanctum on live.
// These values are set in the env file for each deployment 
// with the APP_AUTH_MIDDLEWARE as "auth:sanctum" in live
// and "apiKey" in test.

// However, on local development, there's only one app, and this means there's only one env file.
// In order to mimic 2 different deployments for live and test environments, the logic below
// determines first if this is a local env (2 in 1 deployment) before determining
// which logic to use for authentication. If this is a local environment, 
// please set APP_AUTH_MIDDLEWARE as "localSubdomain" in env file.

$auth_middleware_context = config('auth.env_auth_middleware');

// check the current env value for authentication
if ($auth_middleware_context === "localSubdomain") {
    // Use request subdomain to determine if it's a test context or live context
    $request_root = request()->root();
    $live_domain = config('app.live_app_domain'); // It's a request for live domain... use auth:sanctum else use apiKey
    $authMiddleware = $request_root === $live_domain ? "auth:sanctum" : "apiKey";
} else {
    $authMiddleware = $auth_middleware_context === "apiKey" ? "apiKey" : "auth:sanctum";
}

Route::any('static/test', [AppController::class, 'test']);
Route::any('static/test/save', [AppController::class, 'save']);

Route::middleware($authMiddleware)->get('/user', function (Request $request) {
    return $request->user();
});

// @Middleware noTestRoute: This middleware ensures that this routes are inaccessible by the test app.
Route::group(['prefix' => 'auth', "middleware" => 'noTestRoute'], function () use ($authMiddleware) {
    Route::post('/register', [AuthController::class, 'register'])->middleware('noTestRoute');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/update-password', [AuthController::class, 'updatePassword'])->middleware($authMiddleware);
    Route::post('/passwords/request-token', [AuthController::class, 'forgotPassword']);
    Route::post('/passwords/verify-token', [AuthController::class, 'verifyResetToken']);
    Route::post('/passwords/reset', [AuthController::class, 'resetPassword']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware($authMiddleware);
});

Route::get('/routes', function () use ($authMiddleware) {
    return $authMiddleware;
});


Route::group(['middleware' => [$authMiddleware, 'hasChangedPassword']], function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/roles', [AuthController::class, 'roles']);

    Route::group(['prefix' => 'transactions'], function () {
        Route::get('/', [TransactionController::class, 'index']);
        Route::get('/search', [TransactionController::class, 'show']);
        Route::get('/{transaction_id}/details', [TransactionController::class, 'show']);
    });
    Route::group(['prefix' => 'business'], function () {
        Route::get('/stats', [BusinessController::class, 'getBalance']);
        Route::get('/products', [BusinessController::class, 'getProducts']);
        Route::get('/products-configuration', [ProductController::class, 'getProductsConfiguration']);
        Route::group(["middleware" => ["noTestRoute", "activeBusiness"]], function () {
            Route::post('/switch-env', [BusinessController::class, 'switchEnv'])->middleware('businessUserPermission:switch_business_environment');
            Route::post('/switch-active', [BusinessController::class, 'switchActiveBusiness'])->middleware('businessUserPermission:switch_active_business');
            Route::post('/documents', [BusinessDocumentController::class, 'uploadDocuments'])->middleware('businessUserPermission:upload_business_documents');
            Route::post('/documents/request-approval', [BusinessDocumentController::class, 'requestApproval'])->middleware('businessUserPermission:request_documents_approval');
            Route::get('/documents', [BusinessDocumentController::class, 'showDocuments'])->middleware('businessUserPermission:list_business_documents');

            // Banks
            Route::post('/banks/validate-account', [BankController::class, 'validateAccount'])->middleware('businessUserPermission:validate_business_bank_details');
            Route::post('/banks/validate-otp', [BankController::class, 'validateOtp'])->middleware('businessUserPermission:validate_business_bank_details');

            // Invitations
            Route::post('/invitees', [InviteeController::class, 'sendInvites'])->middleware('businessUserPermission:send_invitations');
            Route::post('/invitees/resend-invite', [InviteeController::class, 'resendInvite'])->middleware('businessUserPermission:resend_invitation');
            Route::get('/invitees', [InviteeController::class, 'showInvitees'])->middleware('businessUserPermission:list_invitations');
            Route::post('/invitees/update-role', [InviteeController::class, 'updateRole'])->middleware('businessUserPermission:set_invitee_role');
            Route::post('/invitees/toggle-activity', [InviteeController::class, 'toggleActivity'])->middleware('businessUserPermission:set_invitee_activity');
            // Whitelist IPs
            Route::get('/whitelist-ips', [BusinessController::class, 'getWhitelistIps'])->middleware('businessUserPermission:get_whitelist_ips');
            Route::post('/whitelist-ips', [BusinessController::class, 'setWhitelistIps'])->middleware('businessUserPermission:set_whitelist_ips');


            Route::post('/user/toggle-notification', [BusinessController::class, 'toggleBusinessNotification'])->middleware('businessUserPermission:toggle_notifications');
            Route::post('/reset-keys', [BusinessController::class, 'resetKeys'])->middleware('businessUserPermission:reset_business_keys');

            // Low Balance Threshold
            Route::get('/low-balance-threshold', [BusinessController::class, 'getLowBalanceThreshold'])->middleware('businessUserPermission:get_low_balance_threshold');
            Route::post('/low-balance-threshold', [BusinessController::class, 'setLowBalanceThreshold'])->middleware('businessUserPermission:set_low_balance_threshold');

            // Low Balance Threshold
            Route::get('/webhook-url', [BusinessController::class, 'getWebhookUrl'])->middleware('businessUserPermission:get_webhook_url');
            Route::post('/webhook-url', [BusinessController::class, 'setWebhookUrl'])->middleware('businessUserPermission:set_webhook_url');

            // Webhook setup

            // Enable/Disable Users

        });
    });
});

Route::group(["middleware" => "noTestRoute"], function () {
    Route::post("/invitations/accept", [InviteeController::class, 'acceptInvite']);
    Route::post("/invitations/view-details", [InviteeController::class, 'viewInviteDetails']);
});

// SUPER ADMIN ROUTES, @madassdev pls remember to add the admin middleware to the routes
Route::group(["middleware" => [
    "noTestRoute", $authMiddleware,
    // "role:" . sc("SUPER_ADMIN_ROLE")
]], function () {
    Route::group(['prefix' => 'super', 'middleware' => ['logAdminAction']], function () {
        Route::get("/transactions/report", [SuperAdminController::class, 'getTransactionsReport']);
        Route::get("/products-commissions", [SuperAdminController::class, 'getProductsCommissions']);
        Route::get("/businesses", [BusinessAdminController::class, 'getBusinesses']);
        Route::get("/businesses/{business_id}", [BusinessAdminController::class, 'getBusinessDetails']);
        Route::get("/businesses/{business_id}/documents", [BusinessAdminController::class, 'getBusinessDocuments']);
        Route::get("/businesses/{business_id}/get-balance", [BusinessAdminController::class, 'getBusinessBalance']);
        Route::get("/businesses/{business_id}/users", [BusinessAdminController::class, 'getBusinessUsers']);
        Route::get("/businesses/{business_id}/products", [BusinessAdminController::class, 'getBusinessProducts']);
        Route::get("/business-documents", [SuperAdminController::class, 'getBusinessDocuments']);
        Route::get("/document-requests", [BusinessAdminController::class, 'getDocumentRequests']);
        Route::post("/businesses", [BusinessAdminController::class, 'createBusiness']);
        Route::post("/businesses/{business_id}/resend-mail", [MailController::class, 'resendAdminCreateBusiness']);
        Route::post("/businesses/{document_request}/approve-documents", [BusinessAdminController::class, 'approveBusinessDocuments']);
        Route::post("/businesses/{business_id}/update-merchant-data", [BusinessAdminController::class, 'setMerchantData']);
        Route::post("/businesses/{business_id}/toggle-live-enabled", [BusinessAdminController::class, 'toggleLiveEnabled']);
        Route::post("/businesses/{business_id}/send-invitations", [BusinessAdminController::class, 'sendBusinessInvites']);
        Route::get('/action-logs', [ActionRequestController::class, 'getAdminActionLogs']);
        /**  Product Configuration
            - Add Product Configurations
            - View Product Configurations
            - Update Product Configurations
            - Delete Product Configurations
            - Commission configuration per product for individual business
            - Product Limits
         */
        // Route::group(['prefix' => 'sub-products'], function () {
        //     Route::get("/", [ProductController::class, 'addSubProduct']);
        //     Route::get("/{subProduct}", [ProductController::class, 'addSubProduct']);
        //     Route::post("/", [ProductController::class, 'addSubProduct']);
        // });
        Route::group(['prefix' => 'products'], function () {
            Route::get("/", [ProductController::class, 'getAllProducts']);
            Route::post("/", [ProductController::class, 'addProduct']);
            Route::get("/{product}", [ProductController::class, 'getOneProduct']);
            Route::put("/{product}", [ProductController::class, 'updateProduct']);
            Route::delete("/{product}", [ProductController::class, 'deleteProduct']);
            // Per business
            Route::get("/{product}/{business}", [ProductController::class, 'getProductConfigurationForBusiness']);
            Route::put("/{product}/{business}", [ProductController::class, 'updateProductConfigurationForBusiness']);
            Route::delete("/{product}/{business}", [ProductController::class, 'deleteProductForBusiness'])->where('product', '[0-9]+')->where('business', '[0-9]+');
            Route::post("/{product}/{business}", [ProductController::class, 'addProductForBusiness'])->where('product', '[0-9]+')->where('business', '[0-9]+');
            // add product to multiple businesses
            Route::post("/{product}/businesses", [ProductController::class, 'addProductForBusinesses']);
            // remove product from multiple businesses
            Route::delete("/{product}/businesses", [ProductController::class, 'removeProductForBusinesses']);
        });

        /**  Transactions
            - View all tansactions
            - View transaction details paginated with query params
         */
        Route::group(['prefix' => 'transactions'], function () {
            Route::get("/", [AdminTransactionController::class, 'index']);
            Route::get("/{transaction_id}", [AdminTransactionController::class, 'show']);
        });

        Route::group(['prefix' => 'admin'], function () {
            Route::post('/', [AdminUserController::class, 'addAdmin']);
            Route::get('/', [AdminUserController::class, 'getAdmins']);
        Route::post("/users/{user}/resend-mail", [MailController::class, 'resendAdminCreateUser']);
        Route::post('/assign-role', [AdminUserController::class, 'assignAdminRole']);
            Route::get('/roles', [AdminUserController::class, 'getRoles']);
            Route::post('/roles', [AdminUserController::class, 'createRole']);
            Route::put('/roles/{role}', [AdminUserController::class, 'updateRole']);
            Route::delete('/roles/{role}', [AdminUserController::class, 'deleteRole']);
            Route::post('/roles/set-permissions', [AdminUserController::class, 'setPermissions']);
        });
        Route::apiResource('banks', BankController::class);
        Route::apiResource('billers', BillerController::class);
        Route::apiResource('business-categories', BusinessCategoryController::class);
        Route::apiResource('product-categories', ProductCategoryController::class);
        Route::apiResource('sub-products', SubProductController::class);

        Route::group(['prefix' => 'actions'], function () {
            Route::get('/', [ActionRequestController::class, 'getActionRequests']);
            Route::group(['prefix' => 'make', 'middleware' => 'role:' . sc("ACTION_MAKER_ROLE")], function () {
                Route::post('create-user', [ActionRequestController::class, 'createUser']);
                Route::post('update-biller', [ActionRequestController::class, 'makeUpdateBiller']);
            });
            Route::group(['prefix' => 'check', 'middleware' => 'role:' . sc("ACTION_CHECKER_ROLE") . '|' . sc("SUPER_ADMIN_ROLE")], function () {
                Route::post('/{actionRequest}', [ActionRequestController::class, 'checkAction']);
            });
        });
    });
});

// Route::group(['prefix' => 'seed'], function () {
//     // Route::post('/business', [BusinessController::class, 'seed']);
// });

// heroku pipelines:promote -r staging


Route::get('business-categories', [BusinessCategoryController::class, 'list']);
Route::get('billers', [BillerController::class, 'index']);
Route::get('banks', [BankController::class, 'getBanks']);
Route::get('product-categories', [ProductController::class, 'listCategories']);
Route::get('/transactions/download', [TransactionController::class, 'download'])->middleware('downloadRoute');
if ($authMiddleware == "apiKey") {
    Route::get("/test-transactions", [AdminTransactionController::class, 'index']);
    Route::get("/test-transactions/{transaction_id}", [AdminTransactionController::class, 'show']);
}
Route::get('/super/transactions/download', [AdminTransactionController::class, 'download'])->middleware('downloadRoute');
