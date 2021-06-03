<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'color_class',
        'model_type',
        'front_visible',
        'sequence'
    ];

    protected $hidden = [
        'model_type',
        'id'
    ];

    private static function getStatus($class, $status)
    {
        return Status::where('model_type', get_class($class))->whereFirst('name', $status);
    }

    public static function vehicleInventory($status)
    {
        return Status::getStatus(new VehicleInventory,$status);
    }

    public static function complaint($status)
    {
        return Status::getStatus(new Complaint,$status);
    }

    public static function maintenanceRequest($status)
    {
        return Status::getStatus(new MaintenanceRequest,$status);
    }

    public function maintenanceQuotation($status)
    {
        return Status::getStatus(new MaintenanceQuotation,$status);
    }
}
