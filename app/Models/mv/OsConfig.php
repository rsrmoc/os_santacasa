<?php

namespace App\Models\mv;

use Illuminate\Database\Eloquent\Model;

class OsConfig extends Model
{
    protected $table = 'DBACAIXA.OS_CONFIG';
    protected $primaryKey = 'CD_OFICINA';
    public $incrementing = false;

    protected $fillable = [
        'CD_OFICINA',
        'TP_CLASSIFICACAO',
        'DS_CLASSIFICACAO',
        'TP_APRAZAMENTO',
        'DS_APRAZAMENTO',
        'SERV_SUPORTE',
        'DS_SUPORTE',
        'FUNCIONARIOS'
    ];
}
