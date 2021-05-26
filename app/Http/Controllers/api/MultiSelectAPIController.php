<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\VehicleInventory;
use Illuminate\Http\Request;

class MultiSelectAPIController extends Controller
{
    public function vehicleInventory(Request $request)
    {
        $data = VehicleInventory::all();

        if ($request->input('search')){
            $data = $data->where('reg_no', 'LIKE', '%{ $request->input("search")} %');
        }

        return $data->map(function ($item) {
            return [
                'value' => $item->id,
                'label' =>  sprintf('%s - %s', $item->reg_no, $item->vehicleCatalog->name)
            ];
        });
    }
}
