<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;

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
            }

            else if ($complaint->status != 1) {
                return 'complaint has been resolved';
            }
        }

        return view('maintenance.create', compact('complaint'));
    }

    public function show($id)
    {
        $maintenance = MaintenanceRequest::find($id);

        if (!isset($maintenance)){
            return 'Invalid Page';
        }

        return view('maintenance.show', compact('maintenance'));
    }

    public function edit($id)
    {
        $maintenance = MaintenanceRequest::find($id);

        if (!isset($maintenance)){
            return 'Invalid Page';
        }

        return view('maintenance.edit', compact('maintenance'));
    }
}
