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

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function maintenanceQuotation()
    {
        return $this->hasMany(MaintenanceQuotation::class);
    }
}
