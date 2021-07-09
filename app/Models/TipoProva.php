<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoProva extends Model
{
    protected $table = 'tiposProva';

    protected $fillable = [
        'nome',
        'cpf',
        'dataNascimento',
    ];
}

