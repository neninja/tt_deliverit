<?php

namespace Core\Models;

use Core\Models\TipoProva;

class Prova
{
    public ?int $id;
    public TipoProva $tipo;
    public \DateTime $data;

    public function __construct($id, $tipo, $data)
    {
        $this->id = $id;
        $this->tipo = $tipo;
        $this->data = $data;
    }
}
