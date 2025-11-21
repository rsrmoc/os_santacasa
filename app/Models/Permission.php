<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';
    protected $primaryKey = 'id_permissions';
    protected $fillable = [
        'id_permissions',
        'cd_permissao',
        'opcao',
        'created_at',
        'updated_at', 
    ];
}
