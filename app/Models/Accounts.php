<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Accounts extends Model
{
    use HasFactory;


    protected $table = 'accounts';

    protected $dateFormat = 'Y/m/d h:i:s';

    protected $fillable = [
        'name',
        'email',
        'password',
        'baranggay'
    ];
}
