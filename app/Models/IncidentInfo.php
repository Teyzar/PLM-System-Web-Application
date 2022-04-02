<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description'
    ];

    public function incident()
    {
        return $this->belongsTo(Incident::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return Carbon::parse($date)->toDayDateTimeString();
    }
}
