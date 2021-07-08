<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Corredor extends Model
{
    protected $table = 'corredores';

    protected $fillable = [
        'nome',
        'cpf',
        'dataNascimento',
    ];
}

