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
        'status_id',
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
        'status_id',
    ];

    protected $appends = [
        'reg_with_name',
        'status'
    ];

    public function vehicleCatalog()
    {
        return $this->belongsTo(VehicleCatalog::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function getRegWithNameAttribute()
    {
        return sprintf('%s - %s', $this->reg_no, $this->vehicleCatalog->name);
    }

    public function getStatusAttribute()
    {
        return $this->status();
    }
}
