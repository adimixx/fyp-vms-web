<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'vehicle_inventory_id',
        'maintenance_category_id',
        'maintenance_unit_id',
        'complaint_id',
        'user_id',
        'name',
        'detail',
        'status',
        'status_note'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'vehicle_inventory_id',
        'maintenance_category_id',
        'maintenance_unit_id',
        'complaint_id',
        'user_id',
    ];
}
