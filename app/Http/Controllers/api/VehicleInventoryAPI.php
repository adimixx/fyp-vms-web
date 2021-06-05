<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Status;
use App\Models\VehicleCategory;
use App\Models\VehicleInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleInventoryAPI extends Controller
{
    public function index($vehicle_category = null, $catalog = null)
    {
        if (isset($vehicle_category) && isset($catalog)) {
            $data = VehicleCategory::find($vehicle_category)?->vehicleCatalog()->find($catalog)?->vehicleInventory()->get();

            if (!isset($data)) {
                return response(['message' => 'Invalid Vehicle Category / Catalog'])->setStatusCode(500);
            }
        } else {
            $data = VehicleInventory::with(['vehicleCatalog', 'vehicleCatalog.vehicleCategory'])->get();
        }

        return $data;
    }

    public function store($vehicle_category, $catalog, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dateReceived' => 'required|date|before_or_equal:today',
            'regNo' => 'required',
            'mileage' => 'required|numeric',
            'nextServiceMileage' => 'required|numeric',
            'nextServiceDate' => 'required|date|after:dateReceived'
        ]);
        $validator->validate();

        $vehicleCatalog = VehicleCategory::find($vehicle_category)?->vehicleCatalog()->find($catalog);

        if (!$vehicleCatalog) {
            return response(array('message' => 'Invalid Vehicle Category / Catalog'))->setStatusCode(500);
        }

        if (VehicleInventory::where('reg_no', $request->regNo)->exists()) {
            return response(['message' => 'The given data was invalid.', 'errors' => [
                "regNo" => [
                    "No Pendaftaran Kenderaan telah wujud"
                ]
            ]])->setStatusCode(500);
        }

        $data = VehicleInventory::create([
            'vehicle_catalog_id' => $vehicleCatalog->id,
            'date_received' => $request->dateReceived,
            'mileage' => $request->mileage,
            'reg_no' => $request->regNo,
            'next_service_date' => $request->nextServiceDate,
            'next_service_mileage' => $request->nextServiceMileage,
            'status_id' => Status::vehicleInventory('available')->id
        ]);

        return $data;
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
