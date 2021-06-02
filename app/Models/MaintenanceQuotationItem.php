<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceQuotationItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'item',
        'quantity',
        'price',
        'subtotal',
        'maintenance_quotation_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function maintenanceQuotation()
    {
       return $this->belongsTo(MaintenanceQuotation::class);
    }
}
