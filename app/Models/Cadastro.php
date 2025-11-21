<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cadastro extends Model
{
    protected $table = 'cadastro';
    protected $primaryKey = 'cd_cadastro';

    protected $fillable = [
        'cd_cadastro',
        'nome_paciente',
        'tipo_convenio',
        'nome_convenio',
        'nome_medico',
        'cd_hospital',
        'data_cirurgia',
    ];
}
