<?php

namespace Core\Contracts\Repositories;

use Core\Models\TipoProva;

interface ITiposProvaRepository
{
    public function findById(int $id): ?TipoProva;
}
