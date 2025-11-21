<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB; 
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Boleto extends Model
{
    use Notifiable;
    protected $table = 'boletos';
    protected $primaryKey = 'cd_boleto';

    protected $fillable = [
        'cd_boleto',
        'id_boleto',
        'cd_condominio',
        'nr_documento',
        'bloco_apto',
        'bloco',
        'apto',
        'nosso_numero',
        'nm_cliente',
        'cpf_puro',
        'cpf_cnpj',
        'grupo_historico',
        'fone',
        'id_unidade',
        'dt_vencimento',
        'dt_registro',
        'dt_emissao',
        'dt_pago',
        'dt_expiracao',
        'vl_boleto',
        'vl_pago',
        'vl_desconto',
        'vl_juros',
        'vl_multa',
        'vl_total',
        'detalhes',
        'key',
        'ds_conta',
        'tipo_conta',
        'status',
        'tp_status',
        'sn_atrasado',
        'forma_pag',
        'centro_custo',
        'impresso_boleto',
        'created_at',
        'updated_at', 
    ];
    public function condominio()
    {
        return $this->belongsTo(Condominio::class,'cd_condominio','cd_condominio'); 
    } 

    public function scopeSearch(Builder $query,$request): Builder
    { 
        $query->with(['condominio' => function($q){
            $q->select('cd_condominio','nm_condominio', 'sn_ativo'); 
        }])
        ->selectRaw("boletos.*,DATE_FORMAT(dt_vencimento, '%d/%m/%Y') data_vencimento,DATE_FORMAT(dt_emissao, '%d/%m/%Y') data_emissao,format(vl_total, 2,'de_DE') valor_total");
        if($request->dti){ 
            $query =$query->where( CONTROLE_DATA[($request->tipo) ? $request->tipo : 'V'] , '>=', $request->dti ); 
        } else {
            $query =$query->where( CONTROLE_DATA[($request->tipo) ? $request->tipo : 'V'] , '>=', date('Y-m-d', strtotime('-5 days', strtotime(date('Y-m-d')))) ); 
        }
 
        if($request->dtf){ 
            $query =$query->where( CONTROLE_DATA[($request->tipo) ? $request->tipo : 'V'] , '<=' , $request->dtf ); 
        } else{
            $query =$query->where( CONTROLE_DATA[($request->tipo) ? $request->tipo : 'V'] , '<=', date('Y-m-d') ); 
        }

        if($request->nome){ 
            $query =$query->whereRaw( " upper(nm_cliente) like '%".mb_strtoupper(($request->nome))."%'" ); 
        }

        if($request->cpf){ 
            $query =$query->whereRaw( " cpf_puro like '%".trim(preg_replace('/[^0-9]/', '', $request->cpf))."%'" ); 
        }

        if($request->agrupamento){ 
            $query =$query->whereRaw( " trim(grupo_historico) = '".trim($request->agrupamento)."'" ); 
        }

        if($request->agrupamento){ 
            $query =$query->whereRaw( " trim(grupo_historico) = '".trim($request->agrupamento)."'" ); 
        }

        if($request->status){ 
            $query =$query->whereIn( "status", $request->status); 
        }
         
        if($request->titulo){ 
            $query =$query->whereRaw( " trim(id_boleto) = '".trim($request->titulo)."'" ); 
        }

        if($request->nr_doc){ 
            $query =$query->whereRaw( " upper(trim(nr_documento)) = '". mb_strtoupper(trim($request->nr_doc))."'" ); 
        }

        if($request->ns_num){ 
            $query =$query->whereRaw( " upper(trim(nosso_numero)) = '". mb_strtoupper(trim($request->ns_num))."'" ); 
        }
        
        if($request->ns_num){ 
            $query =$query->whereRaw( " upper(trim(nosso_numero)) = '". mb_strtoupper(trim($request->ns_num))."'" ); 
        }

        if($request->condominio){ 
            $query =$query->whereRaw( " cd_condominio = '". $request->condominio ."'" ); 
        }
        
        if($request->bloco){ 
            $query =$query->whereRaw( " upper(trim(bloco_apto)) = '%". mb_strtoupper(trim($request->bloco))."%'" ); 
        }
        
        return $query;
    }

}
