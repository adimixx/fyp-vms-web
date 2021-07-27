<?php

namespace App\Models;

use Bayfront\MimeTypes\MimeType;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
        'status_id',
        'status_note',
        'finalize_note',
        'finalize_file'

    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'vehicle_inventory_id',
        'maintenance_category_id',
        'maintenance_unit_id',
        'complaint_id',
        'user_id',
        'status_id',
    ];

    public function vehicleInventory()
    {
        return $this->belongsTo(VehicleInventory::class);
    }

    public function maintenanceCategory()
    {
        return $this->belongsTo(MaintenanceCategory::class);
    }

    public function maintenanceUnit()
    {
        return $this->belongsTo(MaintenanceUnit::class);
    }

    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }

    public function maintenanceQuotation()
    {
        return $this->hasMany(MaintenanceQuotation::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function getFinalizeFileAttribute($value)
    {
        return unserialize($value);
    }

    public function getFinalizeFileVueAttribute()
    {
        $mapImgUrl = function ($v) {
            try {
                $filetype = strstr(MimeType::fromFile($v), '/', true);
                if ($filetype == "image") {
                    return [
                        'type' => $filetype,
                        'thumb' => Storage::disk('azure_maintenance')->url($v),
                        'src' => Storage::disk('azure_maintenance')->url($v)
                    ];
                } else {
                    return [
                        'type' => $filetype,
                        'sources' => [
                            [
                                'src' => Storage::disk('azure_maintenance')->url($v),
                                'type' => MimeType::fromFile($v)
                            ]
                        ],
                        "autoplay" => true
                    ];
                }
            } catch (Exception $e) {
                return [
                    'description' => 'File not exists'
                ];
            }
        };

        return json_encode(array_map($mapImgUrl, $this->media));
    }
}
