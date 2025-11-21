<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tabela extends Model
{
    protected $table = 'tabelas';
    protected $primaryKey = 'cd_tabela';
    protected $fillable = [
        'cd_tabela',
        'campo',
        'valor', 
        'sn_ativo',
        'tp_tabela', 
    ];
}
