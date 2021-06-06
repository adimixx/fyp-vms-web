<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\MaintenanceRequest;
use App\Models\Status;
use App\Models\VehicleInventory;
use Illuminate\Http\Request;

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
    public function index()
    {
        $vehiclesRegistered = VehicleInventory::all();
        $complaintsPending = Complaint::with(['status' => function ($query) {
            return $query->where('name', 'pending');
        }])->get();

        $pendingMaintenance = MaintenanceRequest::with(['status' => function ($query) {
            return $query->where('name', 'pending');
        }])->get();

        $settledMaintenance = MaintenanceRequest::with(['status' => function ($query) {
            return $query->where('name', 'approved');
        }])->get();

        return view('home', compact('vehiclesRegistered', 'complaintsPending', 'pendingMaintenance', 'settledMaintenance'));
    }
}
