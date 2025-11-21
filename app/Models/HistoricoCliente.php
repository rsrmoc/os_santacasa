<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class HistoricoCliente extends Model {
    protected $table = 'historico_cliente';
    protected $primaryKey = 'cd_historico';

    protected $fillable = [
        'cpf_cnpj_cliente',
        'historico',
        'id_usuario',
        'created_at',
        'updated_at'
    ];

    public function usuario() {
        return $this->hasOne(User::class, 'id', 'id_usuario');
    }
}