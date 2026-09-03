<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    protected $connection = 'oracle';
    protected $table = 'DYAD_UNI019.CONTRATO';
    protected $primaryKey = 'chave';

    protected $fillable = [
        'chave', 
    ];
}
