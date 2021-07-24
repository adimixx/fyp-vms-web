<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\MaintenanceQuotation;
use App\Models\MaintenanceRequest;
use App\Models\Status;
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
        $maintenance = MaintenanceRequest::find($id);

        if (!isset($maintenance)) {
            return 'Invalid Page';
        }

        return view('maintenance.edit', compact('maintenance'));
    }
}
