<?php

use App\Helpers\DBSwap;
use App\Http\Controllers\AppController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusinessCategoryController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\BusinessDocumentController;
use App\Http\Controllers\InviteeController;
use App\Http\Controllers\ProductController;
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
    $live_domain = env('LIVE_APP_DOMAIN'); // It's a request for live domain... use auth:sanctum else use apiKey
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
        Route::get('/search', [TransactionController::class, 'search']);
        Route::get('/{transaction}/details', [TransactionController::class, 'index']);
    });
    Route::group(['prefix' => 'business'], function () {
        Route::get('/stats', [BusinessController::class, 'getBalance']);
        Route::get('/products', [BusinessController::class, 'getProducts']);
        Route::group(["middleware" => "noTestRoute"], function () {
            Route::post('/switch-env', [BusinessController::class, 'switchEnv']);
            Route::post('/switch-active', [BusinessController::class, 'switchActiveBusiness']);
            Route::post('/documents', [BusinessDocumentController::class, 'uploadDocuments']);
            Route::get('/documents', [BusinessDocumentController::class, 'showDocuments']);

            // Invitations
            Route::post('/invitees', [InviteeController::class, 'sendInvites']);
            Route::post('/invitees/resend-invite', [InviteeController::class, 'resendInvite']);
            Route::get('/invitees', [InviteeController::class, 'showInvitees']);
            Route::post('/invitees/update-role', [InviteeController::class, 'updateRole']);
            Route::post('/invitees/toggle-activity', [InviteeController::class, 'toggleActivity']);
            // Whitelist IPs
            Route::get('/whitelist-ips', [BusinessController::class, 'getWhitelistIps']);
            Route::post('/whitelist-ips', [BusinessController::class, 'setWhitelistIps']);


            Route::post('/user/toggle-notification', [BusinessController::class, 'toggleBusinessNotification']);
            Route::post('/reset-keys', [BusinessController::class, 'resetKeys']);

            // Low Balance Threshold
            Route::get('/low-balance-threshold', [BusinessController::class, 'getLowBalanceThreshold']);
            Route::post('/low-balance-threshold', [BusinessController::class, 'setLowBalanceThreshold']);

            // Low Balance Threshold
            Route::get('/webhook-url', [BusinessController::class, 'getWebhookUrl']);
            Route::post('/webhook-url', [BusinessController::class, 'setWebhookUrl']);

            // Webhook setup

            // Enable/Disable Users

        });
    });
});

Route::group(["middleware" => "noTestRoute"], function () {
    Route::post("/invitations/accept", [InviteeController::class, 'acceptInvite']);
    Route::post("/invitations/view-details", [InviteeController::class, 'viewInviteDetails']);
});

// Route::group(['prefix' => 'seed'], function () {
//     // Route::post('/business', [BusinessController::class, 'seed']);
// });

// heroku pipelines:promote -r staging


Route::get('business-categories', [BusinessCategoryController::class, 'list']);
Route::get('product-categories', [ProductController::class, 'listCategories']);
Route::get('/transactions/download', [TransactionController::class, 'download'])->middleware('downloadRoute');