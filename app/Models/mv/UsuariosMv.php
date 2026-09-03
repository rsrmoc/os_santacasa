<?php

namespace App\Models\mv;

use Illuminate\Database\Eloquent\Model;

class UsuariosMv extends Model
{ 
    protected $table = 'DBASGU.USUARIOS';
    protected $primaryKey = 'CD_USUARIO';
    public $incrementing = false; 
    protected $keyType = 'string';

    protected $fillable = [
        'CD_USUARIO', 
        'NM_USUARIO', 
        'SN_ATIVO', 
    ];
}
