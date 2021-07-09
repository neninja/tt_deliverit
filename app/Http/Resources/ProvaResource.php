<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProvaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'tipo' => [
                'id' => $this->tipo->id,
                'distanciaEmKM' => $this->tipo->distanciaEmKM
            ],
            'data' => $this->data->format('Y-m-d')
        ];
    }
}

