<?php

namespace App\Models\mv;

use Illuminate\Database\Eloquent\Model;

class TipoOs extends Model
{
    protected $table = 'DBAMV.TIPO_OS';
    protected $primaryKey = 'CD_TIPO_OS';
    public $incrementing = false;

    protected $fillable = [
        'CD_TIPO_OS',
        'NM_TIPO_OS',
    ];



}
