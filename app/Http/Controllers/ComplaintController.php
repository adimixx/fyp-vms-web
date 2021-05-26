<?php

namespace App\Http\Controllers;

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
        //
    }

    public function edit($id)
    {
        //
    }
}
