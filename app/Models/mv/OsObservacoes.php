<?php

namespace App\Models\mv;

use Illuminate\Database\Eloquent\Model;

class OsObservacoes extends Model
{
    protected $table = 'DBARPSYS.OS_OBSERVACOES';
    protected $primaryKey = 'ID';
    public $incrementing = false;

    protected $fillable = [
        'ID',
        'CD_OS',
        'OBS',
        'CD_USUARIO',
        'CREATED_AT',
        'UPDATED_AT'
    ];

    public function tab_func()
    {
        return $this->belongsTo(UsuariosMv::class,'cd_usuario','cd_usuario');
    }

}
