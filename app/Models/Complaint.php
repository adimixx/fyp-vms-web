<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vehicle_inventory_id',
        'name',
        'detail',
        'media',
        'status_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'user_id',
        'vehicle_inventory_id',
        'status_id'
    ];

    public function getMediaAttribute($value)
    {
        return unserialize($value);
    }

    public function vehicleInventory()
    {
        return $this->belongsTo(vehicleInventory::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
