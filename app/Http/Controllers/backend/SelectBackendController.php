<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceQuotation;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SelectBackendController extends Controller
{
    private function returnData($data, $request, $searchCol)
    {
        if ($request->has('ascending') && $request->input('orderBy')) {
            $data = $data->orderBy($request->input('orderBy'), ($request->input('ascending') == 1) ? 'ASC' : 'DESC');
        }

        if ($request->has('search')) {
            $data = $data->where($searchCol, 'like', '%' . $request->input('search') . '%');
        }

        $maxResults = 10;
        return $data->jsonPaginate($maxResults);
    }

    public function confirmQuotation($maintenanceId, Request $request)
    {
        $searchCol = "mv.name";
        $data = MaintenanceQuotation::join('maintenance_vendors AS mv', 'mv.id', 'maintenance_quotations.maintenance_vendor_id')
            ->where('maintenance_quotations.maintenance_request_id', $maintenanceId)
            ->where('maintenance_quotations.status_id', Status::maintenanceQuotation('quoted')->id)
            ->select(DB::raw("CONCAT(mv.name, ' (RM ' , TRUNCATE(maintenance_quotations.cost_total/100, 2) , ')') AS label"), 'maintenance_quotations.id AS value');

        return $this->returnData($data, $request, $searchCol);
    }
}
