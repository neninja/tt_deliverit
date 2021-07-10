<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Corredor extends Model
{
    use HasFactory;

    protected $table = 'corredores';

    protected $fillable = [
        'nome',
        'cpf',
        'dataNascimento',
    ];
}

