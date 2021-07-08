<?php

namespace App\Infra\Repositories\Eloquent;

use Core\Models\Corredor;
use App\Models\Corredor as M;

class CorredoresRepository implements \Core\Contracts\Repositories\ICorredoresRepository
{
    protected function e2m(?Corredor $e)
    {
        $m = new M();
        if(!is_null($e->id)){
            $m->id = $e->id;
        }
        $m->nome = $e->nome;
        $m->cpf = $e->cpf->getNumero();
        $m->dataNascimento = $e->dataNascimento;
        return $m;
    }

    public function save(Corredor $e): Corredor
    {
        $m = $this->e2m($e);
        $m->save();
        $e->id = $m->id;
        return $e;
    }
}
