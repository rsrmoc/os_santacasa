<?php

namespace App\Models\mv;

use Illuminate\Database\Eloquent\Model;

class OfiServ extends Model
{
    protected $table = 'DBAMV.OFI_SERV';
    protected $primaryKey = 'CD_OFICINA';
    public $incrementing = false;

    protected $fillable = [
        'CD_SERVICO',
        'CD_OFICINA',
    ];

    public function tab_servico()
    {
        return $this->belongsTo(ManuServ::class,'cd_servico','cd_servico');
    }
}
