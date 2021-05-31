<?php

use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\VehicleController;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::resource('vehicle', VehicleController::class);
    Route::resource('complaint', ComplaintController::class);
    Route::resource('complaint.maintenance', MaintenanceController::class)->only(['create']);
    Route::resource('maintenance', MaintenanceController::class);
});
