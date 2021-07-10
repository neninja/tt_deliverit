<?php

namespace Core\Contracts\Repositories;

use Core\Models\Inscricao;

interface IInscricoesRepository
{
    public function findById(int $id): ?Inscricao;
    public function save(Inscricao $i): Inscricao;
    public function possuiInscricaoNoDia(\DateTime $dia): bool;
}

