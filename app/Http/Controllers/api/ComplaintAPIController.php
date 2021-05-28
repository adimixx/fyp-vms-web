<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\VehicleInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ComplaintAPIController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required|max:250',
            'vehicle' => 'required|numeric'
        ]);
        $validator->validate();

        $vehicle = VehicleInventory::find($request->vehicle);

        $Complaint = Complaint::create([
            'name' => $request->title,
            'detail'=>$request->description,
            'vehicle_inventory_id' => $vehicle->id,
            'user_id' => 1
        ]);

        return $Complaint;
    }

    public function show($id)
    {
        //
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
