<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FileControllerAPI;
use App\Models\Complaint;
use App\Models\MaintenanceRequest;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
            'status_id' => Status::maintenanceRequest('pending')->id
        ];

        // Update Maintenance
        if (isset($validated->id)) {
            $maintenanceRequest = MaintenanceRequest::find($validated->id)->update($data);
        }
        // New Maintenance
        else {
            if ($request->complaint) {
                $data['complaint_id'] = $validated->complaint;
            }

            $maintenanceRequest = MaintenanceRequest::create($data);
            $maintenanceRequest->complaint()?->update(['status_id' => Status::complaint('pending maintenance')->id]);
        }

        return $maintenanceRequest;
    }

    public function approvalReview(Request $request)
    {
        $validated = (object) Validator::make($request->all(), [
            'id' => ['required', Rule::exists('maintenance_requests', 'id')->where(function ($query) use ($request) {
                return $query->where('status_id', Status::maintenanceRequest('pending approval')->id);
            })],
            'status' => ['required', Rule::exists('statuses', 'sequence')->where(function ($query) use ($request) {
                return $query->where('model_type', get_class(new MaintenanceRequest))->where('front_visible', true);
            })],
            'status_note' => 'nullable|max:250'
        ])->validate();

        $maintenance = MaintenanceRequest::find($validated->id);

        $status = Status::where('model_type', get_class(new MaintenanceRequest))->where('front_visible', true)->where('sequence', $validated->status)->first();

        $maintenance->update([
            'status_id' => $status->id,
            'status_note' => $validated->status_note ?? null
        ]);

        $request->session()->flash('boldMsg', 'Success!');
        $request->session()->flash('msg', 'Maintenance review has been saved');
        $request->session()->flash('classColor', 'success');
        $request->session()->flash('date', 1123);
        return response(['redirect' => route('maintenance.index')]);
    }

    public function finalize(Request $request)
    {
        $validated = (object) Validator::make($request->all(), [
            'id' => ['required', Rule::exists('maintenance_requests', 'id')->where(function ($query) use ($request) {
                return $query->where('status_id', Status::maintenanceRequest('approved')->id);
            })],
            'finalize_note' => 'nullable|max:250',
            'file' => 'nullable'
        ])->validate();

        $maintenance = MaintenanceRequest::find($validated->id);

        if (isset($validated->file)) {
            foreach ((array)$validated->file as $file) {
                Storage::disk('azure_maintenances')->put($file, Storage::disk('local')->get(sprintf('temp/%s', $file)));
                FileControllerAPI::destroyTempFile($file);
            }
        }

        $maintenance->update([
            'finalize_note' => $validated->finalize_note ?? null,
            'finalize_file' => (isset($validated->file)) ? serialize((array)$validated->file) : null,
            'status_id' => Status::maintenanceRequest('completed')->id
        ]);

        $request->session()->flash('boldMsg', 'Success!');
        $request->session()->flash('msg', 'Maintenance has been finalized');
        $request->session()->flash('classColor', 'success');
        $request->session()->flash('date', 1123);
        return response(['redirect' => route('maintenance.index')]);
    }
}
