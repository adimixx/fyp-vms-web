<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartAPIController extends Controller
{

    private function returnData($collection, $label = 'dataset')
    {
        $colors = collect(['pink', 'purple', 'red', 'orange', 'yellow', 'green', 'cyan', 'blue', 'brown']);

        return [
            'labels' => $collection->pluck('LABEL'),
            'datasets' => [
                [
                    'label' => $label,
                    'data' => $collection->pluck('DATA'),
                    'backgroundColor' => $colors->take($collection->count())
                ]
            ]
        ];
    }

    public function SpendingMaintenanceCategories()
    {
        $data = DB::table('maintenance_requests AS MR')
            ->select(DB::raw('round(SUM(MQ.COST_TOTAL)/100,2) AS DATA'), 'MC.NAME AS LABEL')
            ->join('MAINTENANCE_QUOTATIONS AS MQ', 'MQ.MAINTENANCE_REQUEST_ID', 'MR.ID')
            ->join('MAINTENANCE_CATEGORIES AS MC', 'MR.MAINTENANCE_CATEGORY_ID', 'MC.ID')
            ->join('STATUSES AS SMR', 'MR.STATUS_ID', 'SMR.ID')
            ->join('STATUSES AS SMQ', 'MQ.STATUS_ID', 'SMQ.ID')
            ->where('SMR.MODEL_TYPE', 'App\\Models\\MaintenanceRequest')
            ->where('SMR.NAME', 'completed')
            ->where('SMQ.MODEL_TYPE', 'App\\Models\\MaintenanceQuotation')
            ->where('SMQ.NAME', 'approved')
            ->groupBy('MR.MAINTENANCE_CATEGORY_ID')->get();

        return $this->returnData($data, 'Spending by Maintenance Category');
    }

    public function RegisteredVehicleType()
    {
        $data = DB::table('VEHICLE_INVENTORIES AS VI')
            ->select(DB::raw('COUNT(VI.ID) AS DATA'), 'VCG.NAME AS LABEL')
            ->join('VEHICLE_CATALOGS AS VC', 'VI.VEHICLE_CATALOG_ID', 'VC.ID')
            ->join('VEHICLE_CATEGORIES AS VCG', 'VC.vehicle_category_id', 'VCG.ID')
            ->groupBy('VCG.ID')->get();

        return $this->returnData($data, 'Registered Vehicle by Type');
    }
}
