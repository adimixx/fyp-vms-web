<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceQuotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'maintenance_request_id',
        'maintenance_vendor_id',
        'user_id',
        'date_request',
        'date_invoice',
        'cost_total',
        'status_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'maintenance_vendor_id',
        'user_id'
    ];

    public function maintenanceQuotationItem()
    {
        return $this->hasMany(MaintenanceQuotationItem::class);
    }

    public function maintenanceRequest()
    {
        return $this->belongsTo(MaintenanceRequest::class);
    }

    public function maintenanceVendor()
    {
        return $this->belongsTo(MaintenanceVendor::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
