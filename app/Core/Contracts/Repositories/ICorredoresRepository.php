<?php

namespace Core\Contracts\Repositories;

use Core\Models\Corredor;

interface ICorredoresRepository
{
    public function findById(int $id): ?Corredor;
    public function save(Corredor $c): Corredor;
}
