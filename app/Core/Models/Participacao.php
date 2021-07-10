<?php

namespace Core\Models;

use Core\Models\{
    Corredor,
    Prova,
};

class Participacao
{
    public ?int $id;
    public Corredor $corredor;
    public Prova $prova;
    public ?\DateTime $horarioInicio = null;
    public ?\DateTime $horarioFim = null;

    public function __construct($id, $corredor, $prova)
    {
        $this->id = $id;
        $this->corredor = $corredor;
        $this->prova = $prova;
    }
}

