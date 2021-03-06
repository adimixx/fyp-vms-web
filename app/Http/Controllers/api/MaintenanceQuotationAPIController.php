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
    public function show($maintenance, $id)
    {
        $validated = (object) Validator::make(['maintenance' => $maintenance, 'quotation' => $id], [
            'maintenance' => 'required|numeric',
            'quotation' => ['required', 'numeric', Rule::exists('maintenance_quotations', 'id')->where(function ($query) use ($maintenance) {
                return $query->where('maintenance_request_id', $maintenance);
            })]
        ])->validate();

        $quotation = MaintenanceQuotation::with(['maintenanceVendor', 'maintenanceQuotationItem', 'status'])->find($validated->quotation);

        return $quotation;
    }

    public function store(Request $request, $maintenance)
    {
        $validator = Validator::make(array_merge($request->all(), ['maintenance' => $maintenance]), [
            'quotation' => 'numeric|exists:maintenance_quotations,id',
            'maintenance' => 'required|numeric|exists:maintenance_requests,id',
            'vendor' => ['required', 'numeric', 'exists:maintenance_vendors,id', Rule::unique('maintenance_quotations', 'maintenance_vendor_id')->ignore($request->quotation, 'id')->where(function ($query) use ($request) {
                return $query->where('maintenance_request_id', $request->maintenance);
            })],
            'date_request' => 'required|date|before_or_equal:today',
            'status' => ['required', Rule::exists('statuses', 'sequence')->where(function ($query) use ($request) {
                return $query->where('model_type', get_class(new MaintenanceQuotation))->where('front_visible', true);
            })],
            'date_invoice' => 'exclude_unless:status,2|required_if:status,2|date|after_or_equal:date_request|before_or_equal:today',
            'particulars' => 'exclude_unless:status,2|required_if:status,2|array',
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
            return $x += ($y * 100);
        };

        $statusDb = Status::where('sequence', $request->status)->where('model_type', get_class(new MaintenanceQuotation))->where('front_visible', true)->first();

        $data = [
            'maintenance_request_id' => $maintenance,
            'maintenance_vendor_id' => $request->vendor,
            'user_id' => 1,
            'date_request' => $request->date_request,
            'status_id' => $statusDb->id
        ];

        if ($request->status == 2) {
            $data = array_merge($data, [
                'date_invoice' => $request->date_invoice,
                'cost_total' => array_reduce(array_map($arrayMap, $request->particulars), $arrayReduce)
            ]);
        }

        $maintenanceQuotation = MaintenanceQuotation::where('maintenance_request_id', $maintenance)->firstWhere('maintenance_vendor_id', $request->vendor);

        if ($maintenanceQuotation != null) {
            $maintenanceQuotation->update($data);
        } else {
            $maintenanceQuotation = MaintenanceQuotation::create($data);
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
                $maintenanceQuotation->maintenanceQuotationItem()->where('id', $mqi['id'])->first()->update($mqiData);
            }
        }

        return $maintenanceQuotation;
    }

    public function destroy($maintenance, $id)
    {
        $validated = (object) Validator::make(['maintenance' => $maintenance, 'quotation' => $id], [
            'maintenance' => 'required|numeric',
            'quotation' => ['required', 'numeric', Rule::exists('maintenance_quotations', 'id')->where(function ($query) use ($maintenance) {
                return $query->where('maintenance_request_id', $maintenance);
            })]
        ])->validate();

        $maintenanceQuotation = MaintenanceQuotation::find($validated->quotation);

        if ($maintenanceQuotation->maintenanceQuotationItem()->exists()) {
            $maintenanceQuotation->maintenanceQuotationItem()->delete();
        }

        $maintenanceQuotation->delete();

        return response(['messages' => 'Item Deleted']);
    }

    public function confirmQuotation($maintenance, Request $request)
    {
        $validated = (object) Validator::make(array_merge($request->all(), ['maintenance' => $maintenance]), [
            'quotation' => 'required|numeric|exists:maintenance_quotations,id',
            'maintenance' => 'required|numeric|exists:maintenance_requests,id',
        ])->validate();

        $approvedMQ = MaintenanceQuotation::find($validated->quotation);
        $approvedMQ->update(['status_id' => Status::maintenanceQuotation('approved')->id]);

        $declinedMQ = MaintenanceRequest::find($validated->maintenance)->maintenanceQuotation()->where('id', '!=', $validated->quotation)->whereNotIn('status_id', [Status::maintenanceQuotation('pending quote')->id]);
        $declinedMQ->update(['status_id' => Status::maintenanceQuotation('declined')->id]);

        return response(['redirect' => route('maintenance.show', $maintenance)]);
    }
}
