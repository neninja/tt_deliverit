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
        $diff = (new \DateTime())->diff($dataNascimento);
        $idade = $diff->y;
        if($idade < 18)
            throw new ValidationException("Corredor não pode ser menor de idade", $idade);

        $this->id = $id;
        $this->nome = $nome;
        $this->cpf = new CPF($cpf);
        $this->dataNascimento = $dataNascimento;
    }
}
