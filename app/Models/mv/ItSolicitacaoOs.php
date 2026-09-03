<?php

namespace App\Models\mv;

use Illuminate\Database\Eloquent\Model;

class ItSolicitacaoOs extends Model
{
    protected $table = 'DBAMV.ITSOLICITACAO_OS';
    protected $primaryKey = 'CD_ITSOLICITACAO_OS';
    public $incrementing = false;

    protected $fillable = [
        'CD_ITSOLICITACAO_OS',
        'CD_OS',
        'HR_FINAL',
        'HR_INICIO',
        'CD_FUNC',
        'CD_SERVICO',
        'DS_SERVICO'
    ];

    public function tab_func()
    {
        return $this->belongsTo(Funcionario::class,'cd_func','cd_func');
    }
    public function tab_servico()
    {
        return $this->belongsTo(ManuServ::class,'cd_servico','cd_servico');
    }
}
