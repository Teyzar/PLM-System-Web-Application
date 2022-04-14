<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
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
        'formatted_address',
    ];

    public function logs()
    {
        return $this->hasMany(UnitLog::class);
    }

    public function incidents()
    {
        return $this->belongsToMany(Incident::class);
    }

    public function latestIncident()
    {
        return $this->incidents()->orderBy('created_at', 'desc')->first();
    }

    public function isUntracked()
    {
        $latestIncident = $this->latestIncident();

        if (!$latestIncident) return true;

        return $latestIncident->resolved;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return Carbon::parse($date)->toDayDateTimeString();
    }
}
