<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Negociacao extends Model
{
    protected $table = 'negociacoes';
    protected $primaryKey = 'cd_negociacao';

    protected $fillable = [
        'cd_condominio',
        'cd_negociacao',
        'cpf_cnpj_cliente',
        'dt_negociacao',
        'email_cliente',
        'id_usuario',
        'nm_cliente',
        'nr_contato',
        'valor',
        'cd_usuario',
        'status',
        'obs'
    ];

    public static function booted() {
        static::deleting(function($negociacao) {
            $negociacao->boletos()->delete();
        });
    }

    public function condominio()
    {
        return $this->belongsTo(Condominio::class,'cd_condominio','cd_condominio'); 
    }

    public function boletos() {
        return $this->hasMany(NegociacaoBoleto::class, 'cd_negociacao', 'cd_negociacao');
    }
}
