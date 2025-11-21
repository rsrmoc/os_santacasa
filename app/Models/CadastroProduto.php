<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CadastroProduto extends Model
{
    protected $table = 'cadastro_produtos';
    protected $primaryKey = 'cd_cad_produto';

    const UPDATED_AT = null;

    protected $fillable = [
        'cd_cadastro',
        'cd_produto'
    ];
}
