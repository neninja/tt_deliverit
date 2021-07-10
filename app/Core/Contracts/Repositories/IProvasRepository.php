<?php

namespace Core\Contracts\Repositories;

use Core\Models\Prova;

interface IProvasRepository
{
    public function findById(int $id): ?Prova;
    public function save(Prova $p): Prova;
}
