<?php

namespace App;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\UserPermission;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'dbarpsys.users';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'email',
        'email_user',
        'fone',
        'sexo',
        'cd_oficina',
        'cd_funcionario',
        'sn_admin',
        'remember_token',
        'password',
        'created_at',
        'updated_at',
        'dt_password',
        'user_password',
        'user_cadastro',
    ];


    public function permissoes() {
        return $this->hasMany(UserPermission::class, 'user');
    }

    public function isPermissao(string $nome, string $permissao) {

        if ($this->admin) return true;

        $userPermissao = $this->permissoes->where('nome', $nome)->first()->permissoes ?? "";
        return str_contains($userPermissao, $permissao);
    }

    public function existPermissao(string $nome) {
        if ($this->admin) return true;

        return $this->permissoes->where('nome', $nome)->first() ?? false;
    }
}
