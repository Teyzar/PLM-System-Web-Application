<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'street',
        'barangay',
        'city',
        'region'
    ];

    public function unit() {
        return $this->belongsTo(Unit::class);
    }
}
