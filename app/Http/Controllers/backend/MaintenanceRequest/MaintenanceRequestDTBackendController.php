<?php

namespace App\Http\Controllers\backend\MaintenanceRequest;

use App\Http\Controllers\backend\DatatableBackendController;
use App\Http\Controllers\Controller;
use App\Models\MaintenanceRequest;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaintenanceRequestDTBackendController extends Controller
{
    private function maintenance(Request $request, int $vehicle = 0, $status = null)
    {
        $data = MaintenanceRequest::select('maintenance_requests.*', 'inv.reg_no AS reg_no',  DB::raw('CONCAT_WS(\' \',ctlg.brand, ctlg.model, ctlg.variant, CASE WHEN ctlg.year IS NOT NULL THEN CONCAT(\'(\', ctlg.year, \')\') ELSE NULL END) AS model'), 'sts.name AS status_name', 'sts.color_class AS status_class')
            ->join('vehicle_inventories AS inv', 'inv.id', '=', 'maintenance_requests.vehicle_inventory_id')
            ->join('vehicle_catalogs AS ctlg', 'ctlg.id', '=', 'inv.vehicle_catalog_id')
            ->join('vehicle_categories AS ctg', 'ctlg.vehicle_category_id', '=', 'ctg.id')
            ->join('maintenance_units AS mtu', 'maintenance_requests.maintenance_unit_id', '=', 'mtu.id')
            ->join('maintenance_categories AS mtc', 'maintenance_requests.maintenance_category_id', '=', 'mtc.id')
            ->join('statuses AS sts', 'sts.id', '=', 'maintenance_requests.status_id');

        if ($vehicle != 0) {
            $data = $data->where('vehicle_inventory_id', $vehicle);
        }
        else if (isset($status)){
            $data = $data->where('maintenance_requests.status_id', Status::maintenanceRequest($status)->id);
        }
        else {
            $data = $data->whereIn('maintenance_requests.status_id', [Status::maintenanceRequest('dismissed')->id ,Status::maintenanceRequest('rejected')->id ,Status::maintenanceRequest('completed')->id]);
        }

        if ($request->input('query')) {
            // $data = $data->where('reg_no', 'LIKE', "%{$request->input('query')}%");
        }

        $data = $data->orderBy('maintenance_requests.updated_at','desc');

        return DatatableBackendController::returnData($data, $request);
    }

    public function maintenanceApproved(Request $request)
    {
        return $this->maintenance($request, status: 'approved');
    }

    public function maintenanceHistory(Request $request)
    {
        return $this->maintenance($request);
    }
}
