<?php

namespace App\Models\mv;

use Illuminate\Database\Eloquent\Model;

class ManuServ extends Model
{
    protected $table = 'DBAMV.MANU_SERV';
    protected $primaryKey = 'CD_SERVICO';
    public $incrementing = false;

    protected $fillable = [
        'CD_SERVICO',
        'NM_SERVICO',
    ];
}
