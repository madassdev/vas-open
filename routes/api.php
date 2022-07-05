<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusinessDocumentController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/update-password', [AuthController::class, 'updatePassword'])->middleware('auth:sanctum');
    Route::post('/passwords/request-token', [AuthController::class, 'forgotPassword']);
    Route::post('/passwords/verify-token', [AuthController::class, 'verifyResetToken']);
    Route::post('/passwords/reset', [AuthController::class, 'resetPassword']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

Route::group(['middleware'=>['auth:sanctum', 'hasChangedPassword']], function () {
    Route::group(['prefix' => 'account'], function () {
        Route::post('/documents', [BusinessDocumentController::class, 'uploadDocuments']);
    });
});
