<?php

use App\Http\Controllers\api\ComplaintAPIController;
use App\Http\Controllers\api\DatatableAPIController;
use App\Http\Controllers\api\MaintenanceQuotationAPIController;
use App\Http\Controllers\api\MaintenanceRequestAPIController;
use App\Http\Controllers\api\MaintenanceVendorAPIController;
use App\Http\Controllers\api\MultiSelectAPIController;
use App\Http\Controllers\api\UserAPIController;
use App\Http\Controllers\api\VehicleCatalogAPI;
use App\Http\Controllers\api\VehicleCategoryAPI;
use App\Http\Controllers\api\VehicleInventoryAPI;
use App\Http\Controllers\FileControllerAPI;
use App\Models\MaintenanceVendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| BACKEND Routes
|--------------------------------------------------------------------------
*/

Route::name('api.data.')->group(function () {
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::resource('vehicle_category', VehicleCategoryAPI::class);
        Route::resource('vehicle_category.catalog', VehicleCatalogAPI::class);
        Route::resource('vehicle_category.catalog.inventory', VehicleInventoryAPI::class);
        Route::resource('vehicle', VehicleInventoryAPI::class);
        Route::resource('complaint', ComplaintAPIController::class);
        Route::resource('maintenance-request', MaintenanceRequestAPIController::class);
        Route::resource('maintenance.quotation', MaintenanceQuotationAPIController::class);
        Route::resource('file', FileControllerAPI::class);
        Route::resource('user', UserAPIController::class)->only(['store','destroy']);
        Route::resource('maintenance-vendor', MaintenanceVendorAPIController::class)->only(['store','destroy']);
    });

    Route::post('user/register/verify', [UserAPIController::class, 'verifyUser'])->name('user.verify');
});

Route::prefix('datatable')->name('api.datatable.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('vehicle', [DatatableAPIController::class, 'vehicleInventory'])->name('vehicle');
    Route::get('complaint-pending', [DatatableAPIController::class, 'complaintPending'])->name('complaint.pending');
    Route::get('complaint-history', [DatatableAPIController::class, 'complaintHistory'])->name('complaint.history');
    Route::get('complaint/{vehicle}', [DatatableAPIController::class, 'complaintVehicle'])->name('complaint.vehicle');

    Route::get('maintenance-pending', [DatatableAPIController::class, 'maintenancePending'])->name('maintenance.pending');
    Route::get('maintenance-history', [DatatableAPIController::class, 'maintenanceHistory'])->name('maintenance.history');
    Route::get('maintenance/{vehicle}', [DatatableAPIController::class, 'maintenanceVehicle'])->name('maintenance.vehicle');

    Route::get('maintenance/{maintenance_request}/quotation', [DatatableAPIController::class, 'maintenanceQuotation'])->name('maintenance.quotation');
    Route::get('user', [DatatableAPIController::class, 'user'])->name('user');
    Route::get('maintenance-vendor', [DatatableAPIController::class, 'maintenanceVendor'])->name('maintenance-vendor');
});

Route::prefix('multiselect')->middleware(['auth', 'verified'])->name('api.select.')->group(function () {
    Route::get('vehicle', [MultiSelectAPIController::class, 'vehicleInventory'])->name('vehicle');
    Route::get('maintenance-type', [MultiSelectAPIController::class, 'maintenanceType'])->name('maintenance-type');
    Route::get('maintenance-unit', [MultiSelectAPIController::class, 'maintenanceUnit'])->name('maintenance-unit');
    Route::get('vendor', [MultiSelectAPIController::class, 'vendor'])->name('vendor');
    Route::get('status/{model}', [MultiSelectAPIController::class, 'status'])->name('status');
    Route::get('vehicle-catalog/{category}', [MultiSelectAPIController::class, 'vehicleCatalog'])->name('vehicle-catalog');
    Route::get('vehicle-category', [MultiSelectAPIController::class, 'vehicleCategory'])->name('vehicle-category');
});









// Route::resource('vehicle_category.inventory', VehicleCatalogAPI::class);
