<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participacao extends Model
{
    protected $table = 'participacoes';

    protected $fillable = [
        'id_corredor',
        'id_prova',
        'horarioInicio',
        'horarioFim',
    ];

    public function corredor(){
        return $this->belongsTo(Corredor::class, 'id_corredor');
    }

    public function prova(){
        return $this->belongsTo(Prova::class, 'id_prova');
    }
}


