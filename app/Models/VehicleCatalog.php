<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleCatalog extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand',
        'model',
        'variant',
        'year',
        'vehicle_category_id'
    ];

    protected $appends = [
        'name'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'vehicle_category_id'
    ];

    public function getNameAttribute()
    {
        $name = sprintf('%s %s', $this->brand, $this->model);

        if (isset($this->variant)) $name = sprintf('%s %s', $name, $this->variant);
        if (isset($this->year)) $name = sprintf('%s (%s)', $name, $this->year);
        return $name;
    }


    public function vehicleCategories()
    {
        return $this->belongsTo(VehicleCategory::class);
    }

    public function vehicleInventories()
    {
        return $this->hasMany(VehicleInventory::class);
    }



}
