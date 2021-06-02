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
}
