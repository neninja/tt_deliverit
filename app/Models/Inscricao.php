<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscricao extends Model
{
    protected $table = 'inscricoes';

    protected $fillable = [
        'id_corredor',
        'id_prova',
    ];

    public function corredor(){
        return $this->belongsTo(Corredor::class, 'id_corredor');
    }

    public function prova(){
        return $this->belongsTo(Prova::class, 'id_prova');
    }
}


