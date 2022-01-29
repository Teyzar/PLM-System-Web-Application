<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Lineman extends Model
{
    use HasFactory;

    protected $dateFormat = 'Y/m/d h:i:s';

    protected $fillable = [
        'name',
        'email',
        'password',
        'baranggay'
    ];
}
