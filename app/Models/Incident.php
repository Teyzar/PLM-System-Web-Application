<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;

    protected $fillable = [
        'resolved'
    ];

    protected $appends = [
        'info',
        'locations'
    ];

    public function info()
    {
        return $this->hasMany(IncidentInfo::class);
    }

    public function units()
    {
        return $this->belongsToMany(Unit::class);
    }

    public function linemen()
    {
        return $this->belongsToMany(Lineman::class);
    }

    public function getInfoAttribute()
    {
        return $this->info()->orderBy('created_at', 'desc')->get([
            'id', 'title', 'description', 'created_at', 'updated_at'
        ]);
    }

    public function getLocationsAttribute()
    {
        $locations = $this->units()->with('address')->get()->map(function ($unit) {
            return $unit->address()->first();
        })->mapToGroups(function ($item) {
            return [$item['city'] => $item['barangay']];
        })->map(function ($barangays, $city) {
            return [
                'city' => $city,
                'barangays' => collect($barangays)->unique()
            ];
        })->sort();

        return array_values($locations->toArray());
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return Carbon::parse($date)->toDayDateTimeString();
    }
}
