<?php

namespace App\Models\mv;

use Illuminate\Database\Eloquent\Model;

class OsAprazamento extends Model
{
    protected $table = 'DBACAIXA.OS_APRAZAMENTO';
    protected $primaryKey = 'CD_OS';
    public $incrementing = false;

    protected $fillable = [
        'CD_OS',
        'EMAIL',
        'DT_PRAZO',
        'DESCRICAO',
        'USUARIO',
        'CD_FUNC',
        'CREATED_AT',
        'UPDATED_AT',
    ];

    public function tab_responsavel()
    {
        return $this->belongsTo(Funcionario::class,'cd_func','cd_func');
    }

}
