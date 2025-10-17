<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ModuleController;
use App\Http\Controllers\Api\ShortLinkController;
use App\Http\Controllers\Api\UserModuleController;
use App\Http\Controllers\Api\WalletController;
use App\Http\Controllers\Api\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Login and register routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    //to logout
    Route::get('/logout', [AuthController::class, 'logout']);

    //get all modules
    Route::get('/modules', [ModuleController::class, 'index']);
    Route::post('/modules/{module}/activate', [ModuleController::class, 'activate']);
    Route::post('/modules/{module}/deactivate', [ModuleController::class, 'deactivate']);
    Route::get('/modules/active', [UserModuleController::class, 'getUserModulesActive']);

    Route::middleware('check-module-active:1')->group(function () {
        Route::post('/shorten', [ShortLinkController::class, 'shorten']);
        Route::get('/s/{code}', [ShortLinkController::class, 'redirectUrl']);
        Route::get('/links', [ShortLinkController::class, 'index']);
        Route::delete('/links/{short_link}', [ShortLinkController::class, 'destroy']);
    });

    Route::middleware('check-module-active:2')->group(function () {
        Route::get('/wallet', [WalletController::class, 'index']);
        Route::get('/wallet/transactions', [TransactionController::class, 'index']);
        Route::post('/wallet/transfer', [TransactionController::class, 'transfer']);
    });

});
