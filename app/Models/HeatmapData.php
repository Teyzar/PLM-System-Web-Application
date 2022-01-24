<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeatmapData extends Model
{
    use HasFactory;

    protected $fillable = [
        'latitude',
        'longitude',
        'phone_number'
    ];
}
