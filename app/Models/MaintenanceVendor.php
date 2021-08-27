<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaintenanceVendor extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'name',
        'address',
        'phone',
        'email'
    ];

    protected $appends = [
        'pending_quotation',
        'approved_quotation',
        'rejected_quotation'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function maintenanceQuotation()
    {
        return $this->hasMany(MaintenanceQuotation::class);
    }

    private function countQuotation($id)
    {
        return $this->maintenanceQuotation()->where('status_id', $id)->count();
    }

    public function getPendingQuotationAttribute()
    {
        $status = Status::maintenanceQuotation('pending quote')->id;
        return $this->countQuotation($status);
    }

    public function getApprovedQuotationAttribute()
    {
        $status = Status::maintenanceQuotation('approved')->id;
        return $this->countQuotation($status);
    }

    public function getRejectedQuotationAttribute()
    {
        $status = Status::maintenanceQuotation('declined')->id;
        return $this->countQuotation($status);
    }
}
