<?php

use App\Http\Controllers\api\ComplaintAPIController;
use App\Http\Controllers\api\DatatableAPIController;
use App\Http\Controllers\api\MaintenanceQuotationAPIController;
use App\Http\Controllers\api\MaintenanceRequestAPIController;
use App\Http\Controllers\api\MultiSelectAPIController;
use App\Http\Controllers\api\UserAPIController;
use App\Http\Controllers\api\VehicleCatalogAPI;
use App\Http\Controllers\api\VehicleCategoryAPI;
use App\Http\Controllers\api\VehicleInventoryAPI;
use App\Http\Controllers\FileControllerAPI;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::name('api.data.')->group(function () {
//     Route::resource('vehicle_category', VehicleCategoryAPI::class);
//     Route::resource('vehicle_category.catalog', VehicleCatalogAPI::class);
//     Route::resource('vehicle_category.catalog.inventory', VehicleInventoryAPI::class);

//     Route::resource('vehicle', VehicleInventoryAPI::class);
//     Route::resource('complaint', ComplaintAPIController::class);
//     Route::resource('maintenance-request', MaintenanceRequestAPIController::class);
//     Route::resource('maintenance.quotation', MaintenanceQuotationAPIController::class);

//     Route::resource('file', FileControllerAPI::class);

//     Route::resource('user', UserAPIController::class)->only(['store']);
//     Route::post('user/register/verify', [UserAPIController::class, 'verifyUser'])->name('user.verify');
//     Route::post('user/register', [UserAPIController::class, 'registerUser'])->name('user.register');
// });

// Route::prefix('datatable')->name('api.datatable.')->middleware(['auth:sanctum'])->group(function () {
//     Route::get('vehicle', [DatatableAPIController::class, 'vehicleInventory']);
//     Route::get('complaint-pending', [DatatableAPIController::class, 'complaintPending'])->name('complaint.pending');
//     Route::get('complaint-history', [DatatableAPIController::class, 'complaintHistory'])->name('complaint.history');
//     Route::get('complaint/{vehicle}', [DatatableAPIController::class, 'complaintVehicle'])->name('complaint.vehicle');

//     Route::get('maintenance-pending', [DatatableAPIController::class, 'maintenancePending'])->name('maintenance.pending');
//     Route::get('maintenance-history', [DatatableAPIController::class, 'maintenanceHistory'])->name('maintenance.history');
//     Route::get('maintenance/{vehicle}', [DatatableAPIController::class, 'maintenanceVehicle'])->name('maintenance.vehicle');

//     Route::get('maintenance/{maintenance_request}/quotation', [DatatableAPIController::class, 'maintenanceQuotation'])->name('maintenance.quotation');
//     Route::get('user', [DatatableAPIController::class, 'user'])->name('user');
// });

// Route::prefix('multiselect')->name('api.select.')->group(function () {
//     Route::get('vehicle', [MultiSelectAPIController::class, 'vehicleInventory']);
//     Route::get('maintenance-type', [MultiSelectAPIController::class, 'maintenanceType']);
//     Route::get('maintenance-unit', [MultiSelectAPIController::class, 'maintenanceUnit']);
//     Route::get('vendor', [MultiSelectAPIController::class, 'vendor'])->name('vendor');
//     Route::get('status/{model}', [MultiSelectAPIController::class, 'status'])->name('status');
// });









// Route::resource('vehicle_category.inventory', VehicleCatalogAPI::class);
