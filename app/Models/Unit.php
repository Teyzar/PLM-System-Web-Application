<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'latitude',
        'longitude',
        'phone_number',
    ];

    public function incidents()
    {
        return $this->belongsToMany(Incident::class);
    }
}
