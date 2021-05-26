<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\VehicleInventory;
use Illuminate\Http\Request;

class DatatableAPIController extends Controller
{
    private function returnData($data)
    {
        return [
            "data" => $data,
            "count" => count($data)
        ];
    }

    public function vehicleInventory(Request $request)
    {
        $data = VehicleInventory::with(['vehicleCatalog', 'vehicleCatalog.vehicleCategory']);

        // if ($request->input('query')) {
        //     $data = $data->where('reg_no', 'LIKE', "%{$request->input('query')}%");
        // }

        // if ($request->input('limit')) {
        // }
        // if ($request->input('ascending') && $request->input('orderBy')) {
        //     if ($request->input('ascending') == 1) {
        //         $data = $data->orderBy($request->input('orderBy'));
        //     } else {
        //         $data = $data->orderByDesc($request->input('orderBy'));
        //     }
        // }
        // if ($request->input('page')) {

        // }

        $data = $data->get();
        return $this->returnData($data);
    }
}
