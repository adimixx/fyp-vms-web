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
        $maintenance = MaintenanceRequest::all();

        $pendingStatus = Status::maintenanceRequest('pending');
        $pendingApprovalStatus = Status::maintenanceRequest('pending approval');
        $approvedStatus = Status::maintenanceRequest('approved');

        $pendingCount = $maintenance->where('status_id', $pendingStatus->id)->count();
        $pendingApprovalCount = $maintenance->where('status_id', $pendingApprovalStatus->id)->count();
        $approvedCount = $maintenance->where('status_id', $approvedStatus->id)->count();

        return view('maintenance.index', compact('pendingCount', 'pendingApprovalCount', 'approvedCount', 'pendingStatus', 'pendingApprovalStatus', 'approvedStatus'));
    }

    public function create($complaint = null)
    {
        if ($complaint != null) {
            $complaint  = Complaint::find($complaint);
            if (!isset($complaint)) {
                return redirect()->route('maintenance.index')->with('boldMsg', 'Alert')->with('msg', 'Invalid Maintenance')->with('classColor', 'warning')->with('date', 1123);
            } else if ($complaint->status_id != Status::complaint('pending')->id) {
                return redirect()->route('complaint.show', $complaint->id)->with('boldMsg', 'Alert')->with('msg', 'Complaint has been resolved')->with('classColor', 'warning')->with('date', 1123);
            }
        }

        return view('maintenance.create', compact('complaint'));
    }

    public function show($id)
    {
        $maintenance = MaintenanceRequest::find($id);

        if (!isset($maintenance)) {
            return redirect()->route('maintenance.index')->with('boldMsg', 'Alert')->with('msg', 'Invalid Maintenance')->with('classColor', 'warning')->with('date', 1123);
        }
        $quote = $maintenance->maintenanceQuotation()->whereNotIn('status_id', [Status::maintenanceQuotation('approved')->id])->get();
        $quoteSelected = $maintenance->maintenanceQuotation()->where('status_id', Status::maintenanceQuotation('approved')->id)->first();
        return view('maintenance.show', compact('maintenance', 'quote', 'quoteSelected'));
    }

    public function edit($id)
    {
        $maintenance = MaintenanceRequest::with(['maintenanceUnit', 'maintenanceCategory', 'vehicleInventory', 'status'])->find($id);

        if (!isset($maintenance)) {
            return redirect()->route('maintenance.index')->with('boldMsg', 'Alert')->with('msg', 'Invalid Maintenance')->with('classColor', 'warning')->with('date', 1123);
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

        $quote = $quote->get();

        return view('maintenance.confirm-quotation', compact('quote', 'maintenance'));
    }

    public function submitReview($id)
    {
        $maintenance = MaintenanceRequest::find($id);

        if (!isset($maintenance)) {
            return redirect()->route('maintenance.index')->with('boldMsg', 'Alert')->with('msg', 'Invalid Maintenance')->with('classColor', 'warning')->with('date', 1123);
        } else if ($maintenance->maintenanceQuotation()->count() <= 0) {
            return redirect()->route('maintenance.edit', $id)->with('boldMsg', 'Alert')->with('msg', 'Please add a approved quotation before submitting for review')->with('classColor', 'warning')->with('date', 1123);
        } else if ($maintenance->maintenanceQuotation()->where('status_id', Status::maintenanceQuotation('approved')->id)->count() <= 0) {
            return redirect()->route('maintenance.show', $id)->with('boldMsg', 'Alert')->with('msg', 'Please approve a quotation before submitting for review')->with('classColor', 'warning')->with('date', 1123);
        }

        $quote = $maintenance->maintenanceQuotation()->where('status_id', '!=', Status::maintenanceQuotation('approved')->id)->get();
        $quoteSelected = $maintenance->maintenanceQuotation()->where('status_id', Status::maintenanceQuotation('approved')->id)->first();
        return view('maintenance.submit-review', compact('maintenance', 'quote', 'quoteSelected'));
    }

    public function submitReviewPost($id, Request $request)
    {
        $maintenance = MaintenanceRequest::find($id);

        if (!isset($maintenance)) {
            return redirect()->route('maintenance.index')->with('boldMsg', 'Alert')->with('msg', 'Invalid Maintenance')->with('classColor', 'warning')->with('date', 1123);
        } else if ($maintenance->status_id != Status::maintenanceRequest('pending')->id) {
            return redirect()->route('maintenance.show', $id)->with('boldMsg', 'Alert')->with('msg', 'Maintenance is not pending')->with('classColor', 'warning')->with('date', 1123);
        }

        $maintenance->update([
            'status_id' => Status::maintenanceRequest('pending approval')->id
        ]);

        return redirect()->route('maintenance.show', $maintenance->id)->with('boldMsg', 'Success!')->with('msg', 'Maintenance has been submitted for review')->with('classColor', 'success')->with('date', 1123);
    }

    public function approvalReview($id = null)
    {
        if ($id == null) {
            return redirect()->route('maintenance.index');
        }

        $maintenance = MaintenanceRequest::find($id);

        if (!isset($maintenance)) {
            return redirect()->route('maintenance.index')->with('boldMsg', 'Alert')->with('msg', 'Invalid Maintenance')->with('classColor', 'warning')->with('date', 1123);
        } else if ($maintenance->status_id != Status::maintenanceRequest('pending approval')->id) {
            return redirect()->route('maintenance.show', $maintenance->id)->with('boldMsg', 'Alert')->with('msg', 'Maintenance is not pending for review')->with('classColor', 'warning')->with('date', 1123);
        }

        $quote = $maintenance->maintenanceQuotation()->where('status_id', '!=', Status::maintenanceQuotation('approved')->id)->get();
        $quoteSelected = $maintenance->maintenanceQuotation()->where('status_id', Status::maintenanceQuotation('approved')->id)->first();

        $statusOption = Status::where('model_type', get_class(new MaintenanceRequest))->where('front_visible', true)->get()->map(function ($q) {
            return [
                'label' => ucwords($q->name),
                'value' => $q->sequence
            ];
        });

        return view('maintenance.approval-review', compact('maintenance', 'quote', 'quoteSelected', 'statusOption'));
    }

    public function finalize($id)
    {
        $maintenance = MaintenanceRequest::find($id);

        if (!isset($maintenance)) {
            return redirect()->route('maintenance.index')->with('boldMsg', 'Alert')->with('msg', 'Invalid Maintenance')->with('classColor', 'warning')->with('date', 1123);
        }
        else if ($maintenance->status_id != Status::maintenanceRequest('approved')->id) {
            return redirect()->route('maintenance.show', $id)->with('boldMsg', 'Alert')->with('msg', 'Maintenance is not approved')->with('classColor', 'warning')->with('date', 1123);
        }

        $quote = $maintenance->maintenanceQuotation()->whereNotIn('status_id', [Status::maintenanceQuotation('approved')->id])->get();
        $quoteSelected = $maintenance->maintenanceQuotation()->where('status_id', Status::maintenanceQuotation('approved')->id)->first();
        $completedStatus = Status::maintenanceRequest('completed');

        return view('maintenance.finalize', compact('maintenance', 'quote', 'quoteSelected','completedStatus'));
    }
}
