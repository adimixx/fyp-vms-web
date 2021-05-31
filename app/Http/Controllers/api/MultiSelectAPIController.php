<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceCategory;
use App\Models\MaintenanceRequest;
use App\Models\MaintenanceUnit;
use App\Models\MaintenanceVendor;
use App\Models\Status;
use App\Models\VehicleInventory;
use Illuminate\Http\Request;

class MultiSelectAPIController extends Controller
{
    public function vehicleInventory(Request $request)
    {
        $data = VehicleInventory::all();

        if ($request->input('search')) {
            $data = $data->where('reg_no', 'LIKE', '%{ $request->input("search")} %');
        }

        return $data->map(function ($item) {
            return [
                'value' => $item->id,
                'label' => $item->reg_with_name
            ];
        });
    }

    public function maintenanceType(Request $request)
    {
        $data = MaintenanceCategory::all();

        if ($request->input('search')) {
            $data = $data->where('name', 'LIKE', sprintf('%% %s %%', $request->input("search")));
        }

        return $data->map(function ($item) {
            return [
                'value' => $item->id,
                'label' => $item->name
            ];
        });
    }

    public function maintenanceUnit(Request $request)
    {
        $data = MaintenanceUnit::all();

        if ($request->input('search')) {
            $data = $data->where('name', 'LIKE', sprintf('%% %s %%', $request->input("search")));
        }

        return $data->map(function ($item) {
            return [
                'value' => $item->id,
                'label' => $item->code_name
            ];
        });
    }

    public function vendor(Request $request)
    {
        $data = MaintenanceVendor::all();

        if ($request->input('search')) {
            $data = $data->where('name', 'LIKE', '%'. $request->input("search") .'%');
        }

        return $data->map(function ($item) {
            return [
                'value' => $item->id,
                'label' => $item->name
            ];
        });
    }

    public function status($model)
    {
        $data = Status::where('front_visible', true)->get();

        // Maintenance Quotation
        if ($model == 1) {
            $data = $data->where('model_type', '=', get_class(new MaintenanceRequest));
        }

        return $data->map(function ($item, $index) {
            return [
                'value' => $index + 1,
                'label' => $item->name
            ];
        });
    }
}
