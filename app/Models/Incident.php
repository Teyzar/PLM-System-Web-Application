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

    protected function serializeDate(DateTimeInterface $date)
    {
        return Carbon::parse($date)->toDayDateTimeString();
    }
}
