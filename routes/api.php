<?php

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


Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get("/accounts", [\App\Http\Controllers\AccountsController::class, 'getAll']);
    Route::get("/accounts/{id}", [\App\Http\Controllers\AccountsController::class, 'getAccount']);
    Route::post("/accounts/user/{id}", [\App\Http\Controllers\AccountsController::class, 'getAccounts']);
    Route::post("/accounts", [\App\Http\Controllers\AccountsController::class, 'create']);
    Route::post("/accounts/{id}", [\App\Http\Controllers\AccountsController::class, 'update']);
    Route::delete('/accounts/{id}', [\App\Http\Controllers\AccountsController::class, 'delete']);

    Route::get("/user/transaction/{id}", [\App\Http\Controllers\TransactionController::class, 'getTransactions']);
    Route::get("/transaction/{id}", [\App\Http\Controllers\TransactionController::class, 'getTransaction']);
    Route::post("/transaction", [\App\Http\Controllers\TransactionController::class, 'create']);
    Route::post("/transaction/{id}", [\App\Http\Controllers\TransactionController::class, 'update']);
    Route::delete("/transaction/{id}", [\App\Http\Controllers\TransactionController::class, 'delete']);
});
