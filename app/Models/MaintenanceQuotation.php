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
        'status'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function maintenanceQuotationItem()
    {
        return $this->hasMany(MaintenanceQuotationItem::class);
    }
}
