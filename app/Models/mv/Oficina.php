<?php

namespace App\Models\mv;

use Illuminate\Database\Eloquent\Model;

class Oficina extends Model
{ 
    protected $table = 'DBAMV.OFICINA';
    protected $primaryKey = 'CD_OFICINA';
    public $incrementing = false;  

    protected $fillable = [
        'CD_OFICINA', 
        'DS_OFICINA', 
        'CD_SETOR', 
    ];
}
