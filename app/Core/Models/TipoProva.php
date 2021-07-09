<?php

namespace Core\Models;

class TipoProva
{
    public ?int $id;
    public int $distanciaEmKM;

    public function __construct($id, $distancia)
    {
        $this->id = $id;
        $this->distanciaEmKM = $distancia;
    }
}
