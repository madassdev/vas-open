<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\BusinessDocumentController;
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

Route::group(['middleware' => ['auth:sanctum', 'hasChangedPassword']], function () {
    Route::group(['prefix' => 'account'], function () {
        Route::post('/switch-env', [BusinessController::class, 'switchEnv']);
        Route::post('/documents', [BusinessDocumentController::class, 'uploadDocuments']);
    });
});

Route::group(['prefix' => 'seed'], function () {
    // Route::post('/business', [BusinessController::class, 'seed']);
});
