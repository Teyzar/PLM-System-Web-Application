<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class adminAcc extends Model
{
    use HasFactory;

    protected $table = 'admin_accs';
    protected $primaryKey = 'id';


    protected $fillable = ['username', 'password'];
}
