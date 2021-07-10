<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ParticipacaoResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'corredor' => [
                'id' => $this->corredor->id,
                'nome' => $this->corredor->nome,
            ],
            'prova' => [
                'id' => $this->prova->id,
                'data' => $this->prova->data->format('Y-m-d'),
                'distanciaEmKM' => $this->prova->tipo->distanciaEmKM,
            ],
            'horarioInicio' => $this->horarioInicio->format('H:i'),
            'horarioFim' => $this->horarioFim->format('H:i'),
        ];
    }
}


