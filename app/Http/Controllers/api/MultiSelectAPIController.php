<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceCategory;
use App\Models\MaintenanceQuotation;
use App\Models\MaintenanceRequest;
use App\Models\MaintenanceUnit;
use App\Models\MaintenanceVendor;
use App\Models\Status;
use App\Models\VehicleCategory;
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
            $data = $data->where('name', 'LIKE', '%' . $request->input("search") . '%');
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
            $data = $data->where('model_type', get_class(new MaintenanceQuotation));
        }

        $index = 1;

        return $data->map(
            fn ($item) =>
            [
                'value' => $item->sequence,
                'label' => ucwords($item->name)
            ]
        )->values();
    }

    public function vehicleCategory()
    {
        $vehicleCategory = VehicleCategory::all();

        $data = $vehicleCategory->map(fn ($x) => [
            'label' => $x->name,
            'value' => $x->id
        ])->values();

        return $data;
    }

    public function vehicleCatalog(Request $request, $category)
    {
        $catalog = VehicleCategory::find($category)->vehicleCatalog()->get();

        $mappedSelect = $catalog->map(function ($item) {
            return [
                'value' => $item->id,
                'label' => $item->name
            ];
        });

        if (isset($request->search)) {
            $search = $request->search;
            $mappedSelect =  $mappedSelect->filter(function ($item) use ($search) {
                return false !== stripos($item['label'], $search);
            })->values();
        }

        return $mappedSelect;
    }
}
