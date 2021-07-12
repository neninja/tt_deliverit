<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClassificacaoResource extends JsonResource
{
    public $preserveKeys = true;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'corredor' => [
                'id' => $this->id_corredor,
                'nome' => $this->nome,
            ],
            'prova' => [
                'id' => $this->id_prova,
                'data' => $this->data,
                'distanciaEmKM' => $this->distanciaEmKM,
            ],
            'posicao' => $this->posicao
        ];
    }
}


