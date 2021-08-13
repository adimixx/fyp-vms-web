<?php

namespace App\Http\Controllers\api2;

use App\Http\Controllers\api\ComplaintAPIController as ComplaintBackendController;
use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Status;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Boolean;

class ComplaintAPIController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    public function processComplaintList(Request $request, bool $isPending = false)
    {
        // $userId = $request->user()->id;

        $complaint = Complaint::with(['status', 'vehicleInventory.vehicleCatalog.vehicleCategory']);
        // $complaint->where('user_id', $userId);

        if ($isPending) {
            $complaint->where('status_id', Status::complaint('pending')->id);
        }

        $complaint = $complaint->get();

        return $complaint;
    }

    public function getComplaintStats(Request $request)
    {
        // $complaintPending = Complaint::where('user_id', $request->user()->id)->where('status_id', Status::complaint('pending')->id)->count();
        // $processedPending = Complaint::where('user_id', $request->user()->id)->where('status_id', '!=', Status::complaint('pending')->id)->count();

        $complaintPending = Complaint::where('status_id', Status::complaint('pending')->id)->count();
        $processedPending = Complaint::where('status_id', '!=', Status::complaint('pending')->id)->count();

        $reply = ['pending' => $complaintPending, 'processed' => $processedPending];

        return $reply;
    }

    public function index(Request $request)
    {
        return $this->processComplaintList($request);
    }

    public function store(Request $request)
    {
        return (new ComplaintBackendController())->store($request);
    }
}
