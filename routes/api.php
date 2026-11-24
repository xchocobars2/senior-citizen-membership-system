<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MembershipController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - Sanctum Auth + Protected Memberships
|--------------------------------------------------------------------------
*/

// Public auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (require Bearer token)
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    
    Route::get('/memberships', [MembershipController::class, 'index']);
    Route::get('/memberships/{id}', [MembershipController::class, 'show']);
    Route::post('/memberships', [MembershipController::class, 'store']);
    Route::put('/memberships/{id}', [MembershipController::class, 'update']);
    Route::patch('/memberships/{id}', [MembershipController::class, 'update']);
    Route::delete('/memberships/{id}', [MembershipController::class, 'destroy']);
});