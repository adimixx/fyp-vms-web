<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceQuotation;
use App\Models\MaintenanceQuotationItem;
use App\Models\MaintenanceRequest;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class MaintenanceQuotationAPIController extends Controller
{

    public function store(Request $request, $maintenance)
    {
        $validator = Validator::make(array_merge($request->all(), ['maintenance' => $maintenance]), [
            'maintenance' => 'required|numeric|exists:maintenance_requests,id',
            'quotation' => 'numeric|exists:maintenance_quotations,id',
            'vendor' => ['required', 'numeric', 'exists:maintenance_vendors,id', Rule::unique('maintenance_quotations', 'maintenance_vendor_id')->ignore($request->quotation, 'id')->where(function ($query) use ($request) {
                return $query->where('maintenance_request_id', $request->maintenance);
            })],
            'date_request' => 'required|date',
            'status' => ['required', Rule::exists('statuses', 'sequence')->where(function ($query) use ($request) {
                return $query->where('model_type', get_class(new MaintenanceRequest))->where('front_visible', true);
            })],
            'date_invoice' => 'required_if:status,2|date',
            'particulars' => 'required_if:status,2|array',
            'particulars.*.id' => ['numeric', Rule::exists('maintenance_quotation_items', 'id')->where(function ($query) use ($request) {
                return $query->where('maintenance_quotation_id', $request->quotation);
            })],
            'particulars.*.item' => 'required',
            'particulars.*.price' => 'required|numeric|min:0.01',
            'particulars.*.quantity' => 'required|numeric|min:1',

        ]);
        $validator->validate();

        $arrayMap = function ($val) {
            return $val['price'] * $val['quantity'];
        };

        $arrayReduce = function ($x, $y) {
            return $x += $y;
        };

        $statusDb = Status::where('sequence', $request->status)->where('model_type', get_class(new MaintenanceRequest))->where('front_visible', true)->first();

        $data = [
            'maintenance_request_id' => $maintenance,
            'maintenance_vendor_id' => $request->vendor,
            'user_id' => 1,
            'date_request' => $request->date_request,
            'status' => $statusDb->id
        ];

        if ($request->status == 2) {
            $data = array_merge($data, [
                'date_invoice' => $request->date_invoice,
                'cost_total' => array_reduce(array_map($arrayMap, $request->particulars), $arrayReduce)
            ]);
        }

        if (!$request->input('quotation')) {
            $maintenanceQuotation = MaintenanceQuotation::create($data);
        } else {
            $maintenanceQuotation = MaintenanceQuotation::firstWhere('id', $request->quotation)->update($data);
        }

        foreach ($request->particulars as $mqi) {
            $mqiData = [
                'item' => $mqi['item'],
                'quantity' => $mqi['quantity'],
                'price' => ($mqi['price'] * 100),
                'subtotal' => ($mqi['quantity'] * ($mqi['price'] * 100)),
            ];

            if (!isset($mqi['id'])) {
                $maintenanceQuotation->maintenanceQuotationItem()->create($mqiData);
            } else {
                $maintenanceQuotation->maintenanceQuotationItem()->firstWhere('id', $mqi['id'])->update($data);
            }
        }

        return $maintenanceQuotation;
    }
}
