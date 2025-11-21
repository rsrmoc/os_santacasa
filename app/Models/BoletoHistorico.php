<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoletoHistorico extends Model
{
    protected $table = 'boletos_historico';
    protected $primaryKey = 'cd_boleto_hist';

    protected $fillable = [
        'cd_boleto',
        'nome'
    ];
}
