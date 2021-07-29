<?php

namespace App\Http\Controllers\backend\Report;

use App\Http\Controllers\backend\DatatableBackendController;
use App\Http\Controllers\Controller;
use App\Models\MaintenanceQuotation;
use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportDTBackendController extends Controller
{
    public function spendingVehicle(Request $request)
    {
        $data =
            MaintenanceQuotation::from('maintenance_quotations AS mq')
            ->join('maintenance_requests AS mr', 'mr.id', 'mq.maintenance_request_id')
            ->rightJoin('vehicle_inventories AS vi', 'vi.id', 'mr.vehicle_inventory_id')
            ->join('vehicle_catalogs AS vc', 'vc.id', 'vi.vehicle_catalog_id')
            ->join('vehicle_categories AS vcgr', 'vcgr.id', 'vc.vehicle_category_id')
            ->leftJoin('statuses AS smq', 'smq.id', 'mq.status_id')
            ->leftJoin('statuses AS smr', 'smr.id', 'mr.status_id')
            ->where('smq.name', 'approved')
            ->where('smr.name', 'completed')
            ->groupBy('vi.id')
            ->select('vi.id',DB::raw( "CONCAT('RM ', COALESCE(TRUNCATE(SUM(mq.cost_total)/2,2),0)) AS spending"), 'vi.reg_no', DB::raw("CONCAT(COALESCE(vc.brand,''), ' ',COALESCE(vc.model,''), ' ', COALESCE(vc.variant,''), COALESCE(CONCAT('(' , vc.year, ')'),'') ) AS vehicle"), 'vcgr.name AS vehicle_category')
            ->orderBy(DB::raw('COALESCE(SUM(mq.cost_total),0)'),'DESC');

        if ($request->input('query')) {
            // $data = $data->where('reg_no', 'LIKE', "%{$request->input('query')}%");
        }

        return DatatableBackendController::returnData($data, $request);
    }
}
