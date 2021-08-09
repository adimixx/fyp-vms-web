<?php

namespace App\Http\Controllers\api2;

use App\Http\Controllers\Controller;
use App\Models\VehicleInventory;
use Illuminate\Http\Request;

class VehicleInventoryAPIController extends Controller
{

    public function index()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
       $vehicleInventory = VehicleInventory::find($id);
       return $vehicleInventory;
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
