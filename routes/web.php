<?php

use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Route::middleware(['auth', 'verified', 'make_user_active'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::middleware(['role:admin'])->group(function () {
        Route::resource('user', UserController::class);
        Route::resource('maintenance', MaintenanceController::class);
        Route::get('maintenance/{id}/confirm-quotation', [MaintenanceController::class, 'confirmQuotation']);
        Route::resource('complaint.maintenance', MaintenanceController::class)->only(['create']);
        Route::resource('vehicle', VehicleController::class);
        Route::resource('vendor', VendorController::class);
    });

    Route::middleware(['role:staff|admin'])->group(function () {
        Route::resource('complaint', ComplaintController::class);
    });
});
