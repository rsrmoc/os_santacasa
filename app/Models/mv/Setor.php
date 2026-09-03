<?php

namespace App\Models\mv;

use Illuminate\Database\Eloquent\Model;

class Setor extends Model
{
    protected $table = 'DBAMV.SETOR';
    protected $primaryKey = 'CD_SETOR';
    public $incrementing = false;

    protected $fillable = [
        'CD_SETOR',
        'NM_SETOR',
        'CD_FUNC'
    ];



}
