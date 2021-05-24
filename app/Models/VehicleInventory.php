<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleInventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'vehicle_catalog_id',
        'status',
        'reg_no',
        'mileage',
        'last_service_date',
        'next_service_mileage',
        'next_service_date'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'vehicle_catalog_id',
    ];

    public function vehicleCatalog()
    {
        return $this->belongsTo(VehicleCatalog::class);
    }
}
