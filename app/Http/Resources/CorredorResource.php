<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CorredorResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'cpf' => $this->cpf->getNumero(),
            'cpfFormatado' => $this->cpf->formatado(),
            'dataNascimento' => $this->dataNascimento->format('Y-m-d')
        ];
    }
}

