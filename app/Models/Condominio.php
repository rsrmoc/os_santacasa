<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Condominio extends Model
{
    protected $table = 'condominios';
    protected $primaryKey = 'chave';

    protected $fillable = [
        'chave',
        'cd_condominio',
        'nm_condominio',
        'sn_ativo', 
        'created_at',
        'updated_at', 
    ];
}
