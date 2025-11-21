<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bot extends Model
{
    protected $table = 'bot';
    protected $primaryKey = 'cd_bot';
    protected $fillable = [
        'cd_bot',
        'usuario',
        'senha', 
    ];
}
