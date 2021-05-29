<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index()
    {
        return view('complaint.index');
    }

    public function create()
    {
        return view('complaint.create');
    }

    public function show($id)
    {
        $complaint = Complaint::find($id);

        return view('complaint.show', compact('complaint'));
    }

    public function edit($id)
    {
        //
    }
}
