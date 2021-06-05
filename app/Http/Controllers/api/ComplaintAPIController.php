<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Status;
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
            'vehicle' => 'required|numeric|exists:vehicle_inventories,id'
        ]);

        $validated = (object) $validator->validate();

        $complaint = Complaint::create([
            'name' => $validated->title,
            'detail' => $validated->description,
            'vehicle_inventory_id' => $validated->vehicle,
            'user_id' => 1,
            'status_id' => Status::complaint('pending')->id
        ]);

        $complaint->vehicleInventory()->update(['status_id' =>  Status::vehicleInventory('pending complaints')->id]);

        return $complaint;
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
