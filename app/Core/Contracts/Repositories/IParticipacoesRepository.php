<?php

namespace Core\Contracts\Repositories;

use Core\Models\Participacao;

interface IParticipacoesRepository
{
    public function findById(int $id): ?Participacao;
    public function save(Participacao $p): Participacao;
    public function possuiParticipacaoNoDia(int $corredor, \DateTime $dia): bool;
    public function findByCorredorProva(int $c, int $p): ?Participacao;
}

