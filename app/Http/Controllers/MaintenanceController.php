<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\MaintenanceQuotation;
use App\Models\MaintenanceRequest;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaintenanceController extends Controller
{
    public function index()
    {
        return view('maintenance.index');
    }

    public function create($complaint = null)
    {
        if ($complaint != null) {
            $complaint  = Complaint::find($complaint);
            if (!isset($complaint)) {
                return 'Invalid Page';
            } else if ($complaint->status->name != 'pending') {
                return 'complaint has been resolved';
            }
        }

        return view('maintenance.create', compact('complaint'));
    }

    public function show($id)
    {
        $maintenance = MaintenanceRequest::find($id);

        if (!isset($maintenance)) {
            return 'Invalid Page';
        }
        $quote = $maintenance->maintenanceQuotation()->where('status_id', '!=', Status::maintenanceQuotation('approved')->id)->get();
        $quoteSelected = $maintenance->maintenanceQuotation()->where('status_id', Status::maintenanceQuotation('approved')->id)->first();
        return view('maintenance.show', compact('maintenance', 'quote', 'quoteSelected'));
    }

    public function edit($id)
    {
        $maintenance = MaintenanceRequest::with(['maintenanceUnit', 'maintenanceCategory', 'vehicleInventory', 'status'])->find($id);

        if (!isset($maintenance)) {
            return 'Invalid Page';
        }

        $enableNewQuote = ($maintenance->maintenanceQuotation()->where('status_id', Status::maintenanceQuotation('approved')->id)->count() <= 0) ? "true" : "false";

        return view('maintenance.edit', compact('maintenance', 'enableNewQuote'));
    }

    public function confirmQuotation($id)
    {
        $maintenance = MaintenanceRequest::find($id);

        if (strtolower($maintenance->status->name) != 'pending') {
            return redirect()->route('maintenance.show', $id)->with('boldMsg', 'Alert')->with('msg', 'Quotation is not pending')->with('classColor', 'warning')->with('date', 1123);
        }

        $quote = $maintenance->maintenanceQuotation()->whereNotIn('status_id', [Status::maintenanceQuotation('pending quote')->id]);

        if ($quote->count() <= 0) {
            return redirect()->route('maintenance.edit', $id)->with('boldMsg', 'Alert')->with('msg', 'Please add a quoted Quotation')->with('classColor', 'warning')->with('date', 1123);
        }

        $approvedQuote = $quote->where('status_id', [Status::maintenanceQuotation('approved')->id])->first()->id;
        $quote = $quote->get();

        return view('maintenance.confirm-quotation', compact('quote', 'maintenance','approvedQuote'));
    }
}
