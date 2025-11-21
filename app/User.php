<?php

namespace App;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\UserPermission;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'cd_perfil',
        'fone',
        'sexo',
        'remember_token',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
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
