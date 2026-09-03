<?php

namespace App\Models\mv;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{ 
    protected $table = 'DBAMV.FUNCIONARIO';
    protected $primaryKey = 'CD_FUNC';
    public $incrementing = false;  

    protected $fillable = [
        'CD_FUNC', 
        'NM_FUNC', 
        'SN_ATIVO', 
    ];
}
