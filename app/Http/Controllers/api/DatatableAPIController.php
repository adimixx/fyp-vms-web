<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\VehicleInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DatatableAPIController extends Controller
{

    private function returnData($data, $request)
    {
        if ($request->has('ascending') && $request->input('orderBy')){
            $data = $data->orderBy($request->input('orderBy'), ($request->input('ascending') == 1) ? 'ASC' : 'DESC');
        }

        return $data->jsonPaginate();
    }

    public function vehicleInventory(Request $request)
    {
        $data = VehicleInventory::select('vehicle_inventories.*',  DB::raw('CONCAT_WS(\' \',ctlg.brand, ctlg.model, ctlg.variant, CASE WHEN ctlg.year IS NOT NULL THEN CONCAT(\'(\', ctlg.year, \')\') ELSE NULL END) AS model'), 'ctg.name as type')
        ->join('vehicle_catalogs AS ctlg', 'ctlg.id', '=','vehicle_inventories.vehicle_catalog_id')
        ->join('vehicle_categories AS ctg', 'ctlg.vehicle_category_id', '=', 'ctg.id');

        if ($request->input('query')) {
            $data = $data->where('reg_no', 'LIKE', "%{$request->input('query')}%");
        }

        return $this->returnData($data, $request);
    }

    public function complaintPending(Request $request)
    {
        $data = Complaint::select('complaints.*', 'inv.reg_no AS reg_no' ,  DB::raw('CONCAT_WS(\' \',ctlg.brand, ctlg.model, ctlg.variant, CASE WHEN ctlg.year IS NOT NULL THEN CONCAT(\'(\', ctlg.year, \')\') ELSE NULL END) AS model'))
        ->join('vehicle_inventories AS inv', 'inv.id', '=', 'complaints.vehicle_inventory_id')
        ->join('vehicle_catalogs AS ctlg', 'ctlg.id', '=','inv.vehicle_catalog_id')
        ->join('vehicle_categories AS ctg', 'ctlg.vehicle_category_id', '=', 'ctg.id')
        ->where('complaints.status', '1');

        if ($request->input('query')) {
            // $data = $data->where('reg_no', 'LIKE', "%{$request->input('query')}%");
        }

        return $this->returnData($data, $request);
    }
}
