<?php

namespace Core\Contracts\Repositories;

use Core\Models\Prova;

interface IProvasRepository
{
    public function save(Prova $p): Prova;
}
