<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\VehicleCatalog;
use App\Models\VehicleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class VehicleCatalogAPI extends Controller
{
    public function index($vehicle_category, Request $request)
    {
        $catalog = VehicleCategory::find($vehicle_category)->vehicleCatalogs()->get();

        $mappedSelect = $catalog->map(function ($item) {
            return [
                'value' => $item->id,
                'label' => $item->name
            ];
        });

        if (isset($request->search)) {
            $search = $request->search;
            $mappedSelect =  $mappedSelect->filter(function ($item) use ($search) {
                return false !== stripos($item['label'], $search);
            })->values();
        }

        return $mappedSelect;
    }

    public function store($vehicle_category, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand' => 'required',
            'model' => 'required',
            'year' => 'numeric'
        ]);
        $validator->validate();

        $vehicleCat = VehicleCatalog::where('brand', $request->brand)->where('model', $request->model)->where('variant', $request?->variant ?? null)->where('year', $request?->year ?? null);

        if ($vehicleCat->exists()) {
            return $vehicleCat->first();
        }

        $newCat = VehicleCatalog::create([
            'vehicle_category_id' => $vehicle_category,
            'brand' => $request->brand,
            'model' => $request->model,
            'variant' => $request?->variant ?? null,
            'year' => $request?->year ?? null
        ]);

        return $newCat;
    }


    public function show($vehicle_category, $id)
    {
        $data = VehicleCategory::find($vehicle_category)->vehicleCatalogs->find($id);
        return $data;
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
