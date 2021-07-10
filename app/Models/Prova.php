<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prova extends Model
{
    protected $table = 'provas';

    protected $fillable = [
        'data',
    ];

    public function tipo()
    {
        return $this->belongsTo(TipoProva::class, 'id_tipoProva');
    }
}

