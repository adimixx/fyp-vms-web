<?php

namespace App\Models;

use Bayfront\MimeTypes\MimeType;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
        return $this->belongsTo(VehicleInventory::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function getMediaVueAttribute()
    {
        $mapImgUrl = function ($v) {
            try {
                $filetype = strstr(MimeType::fromFile($v), '/', true);
                if ($filetype == "image") {
                    return [
                        'type' => $filetype,
                        'thumb' => Storage::disk('azure_complaints')->url($v),
                        'src' => Storage::disk('azure_complaints')->url($v)
                    ];
                } else {
                    return [
                        'type' => $filetype,
                        'sources' => [
                            [
                                'src' => Storage::disk('azure_complaints')->url($v),
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
