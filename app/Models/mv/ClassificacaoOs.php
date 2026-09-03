<?php

namespace App\Models\mv;

use Illuminate\Database\Eloquent\Model;

class ClassificacaoOs extends Model
{
    protected $table = 'DBACAIXA.CLASSIFICACAO_OS';
    protected $primaryKey = 'CD_OS';
    public $incrementing = false;

    protected $fillable = [
        'CD_OS',
        'CLASSIFICACAO',
        'RESPONSAVEL',
        'CD_TP_OS',
        'CD_MT_SV',
        'CD_SRV',
        'DT_PRAZO',
        'CREATED_AT',
        'UPDATED_AT'
    ];

    public function tab_solicitacao()
    {
        return $this->belongsTo(SolicitacaoOs::class,'cd_os','cd_os');
    }

    public function tab_responsavel()
    {
        return $this->belongsTo(Funcionario::class,'responsavel','cd_func');
    }
}
