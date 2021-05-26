<?php

namespace App\Http\Controllers;

use App\Models\VehicleCatalog;
use App\Models\VehicleCategory;
use App\Models\VehicleInventory;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        return view('vehicle.index');
    }

    public function create()
    {
        $vehicleCat = VehicleCategory::all();

        return view('vehicle.create', compact('vehicleCat'));
    }

    public function show($id)
    {
        $vehicle = VehicleInventory::find($id);

        return view('vehicle.show', compact('vehicle'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
