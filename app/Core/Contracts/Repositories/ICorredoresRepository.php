<?php

namespace Core\Contracts\Repositories;

use Core\Models\Corredor;

interface ICorredoresRepository
{
    public function save(Corredor $c): Corredor;
}
