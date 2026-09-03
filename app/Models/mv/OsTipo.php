<?php

namespace App\Models\mv;

use Illuminate\Database\Eloquent\Model;

class OsTipo extends Model
{
    protected $table = 'DBACAIXA.OS_TIPO';
    protected $primaryKey = 'ID';
    public $incrementing = false;

    protected $fillable = [
        'ID',
        'CD_TP_OS',
        'CD_OFICINA',
    ];
}
