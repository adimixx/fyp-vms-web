<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\MaintenanceRequest;
use App\Models\Status;
use App\Models\VehicleInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if (!$request->user()->hasAnyRole('admin', 'management')){
            if ($request->user()->hasAnyRole('staff')){
                return redirect()->route('complaint.index');
            }
            elseif ($request->user()->hasAnyRole('committee')){
                return redirect()->route('maintenance.index');
            }
        }

        $vehiclesRegistered = VehicleInventory::count();
        $complaintsPending = Complaint::where('status_id', Status::complaint('pending')->id)->count();
        $pendingMaintenance = MaintenanceRequest::where('status_id', Status::maintenanceRequest('pending')->id)->count();
        $settledMaintenance = MaintenanceRequest::where('status_id', Status::maintenanceRequest('completed')->id)->count();

        return view('home', compact('vehiclesRegistered', 'complaintsPending', 'pendingMaintenance', 'settledMaintenance'));
    }
}
