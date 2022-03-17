<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentInfo extends Model
{
    use HasFactory;

    protected $table = 'incident_info';

    protected $filable = [
        'title',
        'description'
    ];

    public function incident()
    {
        return $this->belongsTo(Incident::class);
    }
}
