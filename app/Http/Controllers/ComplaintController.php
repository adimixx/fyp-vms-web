<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Bayfront\MimeTypes\MimeType;

class ComplaintController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:complaint:crud_self']);
    }

    public function index()
    {
        return view('complaint.index');
    }

    public function create()
    {
        return view('complaint.create');
    }

    public function show($id, Request $request)
    {
        $complaint = Complaint::find($id);
        if (!$request->user()->can('complaint:crud_all') && $complaint->user_id != $request->user()->id){
            return redirect()->route('complaint.index')->with('boldMsg', 'Alert')->with('msg', 'Access is Prohibited')->with('classColor', 'danger')->with('date', 1123);
        }

        return view('complaint.show', compact('complaint'));
    }
}
