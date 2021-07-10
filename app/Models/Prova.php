<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prova extends Model
{
    use HasFactory;

    protected $table = 'provas';

    protected $fillable = [
        'data',
    ];

    public function tipo()
    {
        return $this->belongsTo(TipoProva::class, 'id_tipoProva');
    }
}

