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
    ];

    protected $appends = ['formatted_address'];

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

    public function address()
    {
        return $this->hasOne(UnitAddress::class);
    }

    public function getFormattedAddressAttribute()
    {
        $address = $this->address()->first();

        if (!$address) return;

        $locations = collect([
            $address->street,
            $address->barangay,
            $address->city,
            $address->region
        ])->filter(function ($attribute) {
            return $attribute;
        })->toArray();

        return implode(', ', $locations);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return Carbon::parse($date)->toDayDateTimeString();
    }
}
