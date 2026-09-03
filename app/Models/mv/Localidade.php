<?php

namespace App\Models\mv;

use Illuminate\Database\Eloquent\Model;

class Localidade extends Model
{
    protected $table = 'DBAMV.LOCALIDADE';
    protected $primaryKey = 'CD_LOCALIDADE';
    public $incrementing = false;

    protected $fillable = [
        'CD_LOCALIDADE',
        'NM_LOCALIDADE',
    ];



}
