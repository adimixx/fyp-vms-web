<?php

use App\Http\Controllers\api2\ComplaintAPIController;
use App\Http\Controllers\api2\UserAPIController;
use App\Http\Controllers\api2\VehicleInventoryAPIController;
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


Route::post('token', [UserAPIController::class, 'login']);
Route::get('user', [UserAPIController::class, 'getAuthUser']);

Route::resource('complaint', ComplaintAPIController::class)->only(['index', 'store'])->names(['index' => 'cIndex', 'store' => 'cStore']);
Route::get('complaint/stats', [ComplaintAPIController::class, 'getComplaintStats']);

Route::resource('vehicle/inventory', VehicleInventoryAPIController::class);
