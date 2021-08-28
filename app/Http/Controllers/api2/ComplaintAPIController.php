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
        $user = $request->user();

        $complaint = Complaint::with(['status', 'vehicleInventory.vehicleCatalog.vehicleCategory']);

        if (!$user->hasRole(['admin', 'management'])) {
            $complaint->where('user_id', $user->id);
        }

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

        $complaintPending = Complaint::where('status_id', Status::complaint('pending')->id);
        $processedPending = Complaint::where('status_id', '!=', Status::complaint('pending')->id);

        $user = $request->user();
        if (!$user->hasRole(['admin', 'management'])) {
            $complaintPending->where('user_id', $user->id);
            $processedPending->where('user_id', $user->id);
        }

        $reply = ['pending' => $complaintPending->count(), 'processed' => $processedPending->count()];

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
