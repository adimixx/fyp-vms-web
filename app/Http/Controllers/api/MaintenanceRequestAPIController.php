<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\MaintenanceRequest;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MaintenanceRequestAPIController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'numeric|exists:maintenance_requests,id',
            'complaint' => 'numeric|exists:complaints,id',
            'vehicle' => 'required|numeric|exists:vehicle_inventories,id',
            'maintenanceType' => 'required|numeric|exists:maintenance_categories,id',
            'maintenanceUnit' => 'required|numeric||exists:maintenance_units,id',
            'title' => 'required|max:50',
            'description' => 'required|max:250',
        ]);
        $validated = (object) $validator->validate();

        $data = [
            'vehicle_inventory_id' => $validated->vehicle,
            'maintenance_category_id' => $validated->maintenanceType,
            'maintenance_unit_id' => $validated->maintenanceUnit,
            'name' => $validated->title,
            'detail' => $validated->description,
            'user_id' => 1,
            'code' => sprintf('%s%s', $validated->maintenanceUnit, 1),
            'status' => Status::maintenanceRequest('pending')->id
        ];

        // Update Maintenance
        if ($validated->id) {
            $maintenanceRequest = MaintenanceRequest::find($validated->id)->update($data);
        }
        // New Maintenance
        else {
            if ($request->complaint) {
                $data['complaint_id'] = $validated->complaint;
            }

            $maintenanceRequest = MaintenanceRequest::create($data);
            $maintenanceRequest->status()?->save(Status::complaint('pending maintenance'));
        }

        return $maintenanceRequest;
    }
}
