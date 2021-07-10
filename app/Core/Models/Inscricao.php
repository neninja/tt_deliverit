<?php

namespace Core\Models;

use Core\Models\{
    Corredor,
    Prova,
};

class Inscricao
{
    public ?int $id;
    public Corredor $corredor;
    public Prova $prova;

    public function __construct($id, $corredor, $prova)
    {
        $this->id = $id;
        $this->corredor = $corredor;
        $this->prova = $prova;
    }
}

