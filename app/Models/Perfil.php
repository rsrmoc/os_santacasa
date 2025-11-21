<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table = 'perfis';
    protected $primaryKey = 'cd_perfil';

    protected $fillable = [
        'cd_perfil',
        'nm_perfil', 
        'sn_ativo', 
        'created_at',
        'updated_at', 
    ];
}
