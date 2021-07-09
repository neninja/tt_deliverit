<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prova extends Model
{
    protected $table = 'provas';

    protected $fillable = [
        'data',
        'id_tiposProva',
    ];

    public function tipoProva(){
        return $this->belongsTo(TipoProva::class, 'id_tiposProva');
    }
}

