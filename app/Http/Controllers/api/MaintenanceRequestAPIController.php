<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MaintenanceRequestAPIController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'complaint' => 'numeric|exists:complaints,id',
            'vehicle' => 'required|numeric|exists:vehicle_inventories,id',
            'maintenanceType' => 'required|numeric|exists:maintenance_categories,id',
            'maintenanceUnit' => 'required|numeric||exists:maintenance_units,id',
            'title' => 'required|max:50',
            'description' => 'required|max:250',
        ]);
        $validator->validate();

        $data = [
            'vehicle_inventory_id' => $request->vehicle,
            'maintenance_category_id' => $request->maintenanceType,
            'maintenance_unit_id' => $request->maintenanceUnit,
            'name' => $request->title,
            'detail' => $request->description,
            'user_id' => 1,
            'code' => sprintf('%s%s', $request->maintenanceUnit, 1),
            'status' => 1
        ];

        if ($request->has('complaint')) {
            $data['complaint_id'] = $request->complaint;
        }

        $maintenanceRequest = MaintenanceRequest::create($data);

        return $maintenanceRequest;
    }
}