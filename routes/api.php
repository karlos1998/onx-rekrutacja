<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AddressController;

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

Route::get('/emailAvailable', [AuthController::class, 'emailAvailable']);

/** Registration */
Route::post('/user', [AuthController::class, 'createAccount']);

/* Login */
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    
    /** Get info about me */
    Route::get('/user', [AuthController::class, 'index']);
    
    Route::post('/logout', [AuthController::class, 'logout']);


    Route::post('/address', [AddressController::class, 'store'])->middleware(['permission:all-addresses-create|own-addresses-create']);
    Route::get('/addresses', [AddressController::class, 'index'])->middleware(['permission:all-addresses-read|own-addresses-read']);
    Route::delete('/address/{address}', [AddressController::class, 'delete'])->middleware(['permission:all-addresses-delete|own-addresses-delete']);
    Route::delete('/addresses', [AddressController::class, 'deleteMany'])->middleware(['permission:all-addresses-delete|own-addresses-delete']);
});