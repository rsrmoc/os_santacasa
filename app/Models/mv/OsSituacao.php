<?php

namespace App\Models\mv;

use Illuminate\Database\Eloquent\Model;

class OsSituacao extends Model
{
    protected $table = 'DBARPSYS.OS_SITUACAO';
    protected $primaryKey = 'CD_SITUACAO';
    public $incrementing = false;

    protected $fillable = [
        'CD_SITUACAO',
        'NM_SITUACAO',
        'TIPO',
        'ICONE',
        'COR'
    ];
}
