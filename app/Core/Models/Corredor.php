<?php

namespace Core\Models;

use Core\Exceptions\ValidationException;
use Core\Models\CPF;

class Corredor
{
    public ?int $id;
    public string $nome;
    public CPF $cpf;
    public \DateTime $dataNascimento;

    public function __construct(
        $id,
        $nome,
        string $cpf,
        $dataNascimento
    ) {
        $this->id = $id;
        $this->nome = $nome;
        $this->cpf = new CPF($cpf);
        $this->dataNascimento = $dataNascimento;
    }
}
