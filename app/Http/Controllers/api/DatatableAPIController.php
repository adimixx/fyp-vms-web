<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\MaintenanceQuotation;
use App\Models\MaintenanceRequest;
use App\Models\Status;
use App\Models\User;
use App\Models\VehicleInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Boolean;
use Psy\Command\WhereamiCommand;
use Symfony\Component\Console\Input\Input;

class DatatableAPIController extends Controller
{
    private function returnData($data, $request)
    {
        if ($request->has('ascending') && $request->input('orderBy')) {
            $data = $data->orderBy($request->input('orderBy'), ($request->input('ascending') == 1) ? 'ASC' : 'DESC');
        }

        return $data->jsonPaginate();
    }

    private function complaint(Request $request, int $vehicle = 0, bool $isPending = false)
    {
        $data = Complaint::select('complaints.*', 'inv.reg_no AS reg_no',  DB::raw('CONCAT_WS(\' \',ctlg.brand, ctlg.model, ctlg.variant, CASE WHEN ctlg.year IS NOT NULL THEN CONCAT(\'(\', ctlg.year, \')\') ELSE NULL END) AS model'), 'sts.name AS status_name', 'sts.color_class AS status_class')
            ->join('vehicle_inventories AS inv', 'inv.id', '=', 'complaints.vehicle_inventory_id')
            ->join('vehicle_catalogs AS ctlg', 'ctlg.id', '=', 'inv.vehicle_catalog_id')
            ->join('vehicle_categories AS ctg', 'ctlg.vehicle_category_id', '=', 'ctg.id')
            ->join('statuses AS sts', 'sts.id', '=', 'complaints.status_id');

        if ($vehicle != 0) {
            $data = $data->where('vehicle_inventory_id', $vehicle);
        } else if ($isPending) {
            $data = $data->where('complaints.status_id', Status::complaint('pending')->id);
        } else {
            $data = $data->where('complaints.status_id', '!=', Status::complaint('pending')->id);
        }

        if (!$request->user()->hasRole('admin')) {
            $data = $data->where('user_id', '=',$request->user()->id);
        }

        if ($request->input('query')) {
            // $data = $data->where('reg_no', 'LIKE', "%{$request->input('query')}%");
        }

        return $this->returnData($data, $request);
    }

    private function maintenance(Request $request, int $vehicle = 0, bool $isPending = false)
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
        } else if ($isPending) {
            $data = $data->where('maintenance_requests.status_id', Status::maintenanceRequest('pending')->id);
        } else {
            $data = $data->where('maintenance_requests.status_id', '!=', Status::maintenanceRequest('pending')->id);
        }

        if ($request->input('query')) {
            // $data = $data->where('reg_no', 'LIKE', "%{$request->input('query')}%");
        }

        return $this->returnData($data, $request);
    }


    public function vehicleInventory(Request $request)
    {
        $data = VehicleInventory::select('vehicle_inventories.*',  DB::raw('CONCAT_WS(\' \',ctlg.brand, ctlg.model, ctlg.variant, CASE WHEN ctlg.year IS NOT NULL THEN CONCAT(\'(\', ctlg.year, \')\') ELSE NULL END) AS model'), 'ctg.name as type')
            ->join('vehicle_catalogs AS ctlg', 'ctlg.id', '=', 'vehicle_inventories.vehicle_catalog_id')
            ->join('vehicle_categories AS ctg', 'ctlg.vehicle_category_id', '=', 'ctg.id');

        if ($request->input('query')) {
            $data = $data->where('reg_no', 'LIKE', "%{$request->input('query')}%");
        }

        return $this->returnData($data, $request);
    }

    public function complaintPending(Request $request)
    {
        return $this->complaint($request, isPending: true);
    }

    public function complaintHistory(Request $request)
    {
        return $this->complaint($request);
    }

    public function complaintVehicle($vehicle, Request $request)
    {
        return $this->complaint($request, vehicle: $vehicle);
    }

    public function maintenancePending(Request $request)
    {
        return $this->maintenance($request, isPending: true);
    }

    public function maintenanceHistory(Request $request)
    {
        return $this->maintenance($request);
    }

    public function maintenanceVehicle($vehicle, Request $request)
    {
        return $this->maintenance($request, vehicle: $vehicle);
    }

    public function maintenanceQuotation($maintenance_request, Request $request)
    {
        $validator = Validator::make([
            'maintenance_request' => $maintenance_request
        ], [
            'maintenance_request' => 'required|numeric|exists:maintenance_requests,id',
        ]);
        $validator->validate();

        $data = MaintenanceQuotation::select('maintenance_quotations.*', 'mtv.name AS vendor', 'sts.name AS status_name', 'sts.color_class AS status_class')
            ->join('maintenance_requests AS mtr', 'mtr.id', '=', 'maintenance_quotations.maintenance_request_id')
            ->join('maintenance_vendors AS mtv', 'mtv.id', '=', 'maintenance_quotations.maintenance_vendor_id')
            ->join('statuses AS sts', 'sts.id', '=', 'maintenance_quotations.status_id')
            ->where('maintenance_request_id', '=', $maintenance_request);

        return $this->returnData($data, $request);
    }

    public function user(Request $request)
    {
        $data = User::with(['roles:name,id', 'status']);

        return $this->returnData($data, $request);
    }
}
