<?php

namespace App\Models\mv;

use Illuminate\Database\Eloquent\Model;

class ManuEspec extends Model
{
    protected $table = 'DBAMV.MANU_ESPEC';
    protected $primaryKey = 'CD_ESPEC';
    public $incrementing = false;

    protected $fillable = [
        'CD_ESPEC',
        'NM_ESPEC',
        'SN_ZELADORIA'
    ];


}
