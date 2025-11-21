<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    protected $table = 'hospital';
    protected $primaryKey = 'cd_hospital';

    protected $fillable = ['nm_hospital'];
}
