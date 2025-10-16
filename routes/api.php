<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ModuleController;
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
});
