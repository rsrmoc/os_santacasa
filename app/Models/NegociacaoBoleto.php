<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NegociacaoBoleto extends Model {
    protected $table = 'negociacoes_boleto';
    protected $primaryKey = 'cd_negociacao_boleto';

    protected $fillable = [
        'cd_negociacao',
        'cd_boleto',
        'id_usuario',
        'created_at',
        'updated_at'
    ];

    public function boleto() {
        return $this->hasOne(Boleto::class, 'cd_boleto', 'cd_boleto');
    }
}