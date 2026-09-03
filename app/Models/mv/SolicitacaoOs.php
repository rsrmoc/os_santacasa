<?php

namespace App\Models\mv;

use Illuminate\Database\Eloquent\Model;

class SolicitacaoOs extends Model
{
    protected $table = 'DBAMV.SOLICITACAO_OS';
    protected $primaryKey = 'CD_OS';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'CD_OS',
        'DT_PEDIDO',
        'DS_SERVICO',
    ];

    public function tab_it_solicitacao()
    {
        return $this->hasMany(ItSolicitacaoOs::class,'cd_os','cd_os')
        ->orderBy("cd_itsolicitacao_os","desc");
    }

    public function tab_setor()
    {
        return $this->belongsTo(Setor::class,'cd_setor','cd_setor');
    }

    public function tab_espec()
    {
        return $this->belongsTo(ManuEspec::class,'cd_espec','cd_espec');
    }

    public function tab_tipo_os()
    {
        return $this->belongsTo(TipoOs::class,'cd_tipo_os','cd_tipo_os');
    }

    public function tab_localidade()
    {
        return $this->belongsTo(Localidade::class,'cd_localidade','cd_localidade');
    }

    public function tab_oficina()
    {
        return $this->belongsTo(Oficina::class,'cd_oficina','cd_oficina');
    }

    public function tab_classificacao()
    {
        return $this->belongsTo(ClassificacaoOs::class,'cd_os','cd_os')
        ->selectRaw("classificacao_os.*,
        case when dt_prazo is null then 'bg-dias' when dt_prazo < sysdate and dt_prazo is not null then 'bg-vencido' else 'bg-prazos' end as class_prazo");
    }

    public function tab_situacao()
    {
        return $this->belongsTo(OsSituacao::class,'tp_situacao','cd_situacao');
    }

    public function tab_aprazamento()
    {
        return $this->hasMany(OsAprazamento::class,'cd_os','cd_os');
    }

    public function tab_observacao()
    {
        return $this->hasMany(OsObservacoes::class,'cd_os','cd_os')
        ->orderBy('created_at', 'desc');
    }
}
