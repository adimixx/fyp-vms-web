<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceVendor;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MaintenanceVendorAPIController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'nullable|exists:maintenance_vendors',
            'name' => ['required', Rule::unique(MaintenanceVendor::class)->ignore($request->id)],
            'address' => 'nullable',
            'email' => ['nullable', 'email', Rule::unique(MaintenanceVendor::class)->ignore($request->id)],
            'phone' => ['nullable', Rule::unique(MaintenanceVendor::class)->ignore($request->id)]
        ]);
        $validated = $validator->validate();

        if (isset($validated['id'])) {
            $vendor = MaintenanceVendor::find($validated['id']);

            $vendor->update($validated);
        } else {
            $vendor = MaintenanceVendor::create($validated);
        }

        return $vendor;
    }


    public function destroy($id)
    {
        $vendor = MaintenanceVendor::find($id);

        if ($vendor->maintenanceQuotation()->exists()) {
            return response(['message' => 'Vendor has pending quotation'], 500);
        }

        $vendor->delete();

        return response(['message' => 'delete success']);
    }
}
