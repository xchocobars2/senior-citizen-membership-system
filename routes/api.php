<?php

use App\Http\Controllers\Api\MembershipController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - Senior Citizen Memberships CRUD
|--------------------------------------------------------------------------
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public read endpoints (optional – you can protect them later)
Route::get('/memberships', [MembershipController::class, 'index']);
Route::get('/memberships/{id}', [MembershipController::class, 'show']);

// Write operations (Create, Update, Delete)
Route::post('/memberships', [MembershipController::class, 'store']);
Route::put('/memberships/{id}', [MembershipController::class, 'update']);
Route::patch('/memberships/{id}', [MembershipController::class, 'update']);
Route::delete('/memberships/{id}', [MembershipController::class, 'destroy']);