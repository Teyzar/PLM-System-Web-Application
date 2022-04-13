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
        'latitude',
        'longitude',
        'phone_number',
    ];

    protected $append = ['status'];

    public function getStatusAttribute()
    {
        return $this->hasOne(UnitLog::class)->latestOfMany()->first()->status;
    }

    public function logs()
    {
        return $this->hasMany(UnitLog::class);
    }

    public function incidents()
    {
        return $this->belongsToMany(Incident::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return Carbon::parse($date)->toDayDateTimeString();
    }
}
