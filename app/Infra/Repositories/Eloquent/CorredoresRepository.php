<?php

namespace App\Infra\Repositories\Eloquent;

use Core\Models\Corredor;
use App\Models\Corredor as M;

class CorredoresRepository implements \Core\Contracts\Repositories\ICorredoresRepository
{
    public static function e2m(Corredor $e)
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

    public static function m2e(?M $m): ?Corredor
    {
        return $m ? new Corredor(
            $m->id,
            $m->nome,
            $m->cpf,
            date_create_from_format('Y-m-d', $m->dataNascimento)
        ) : null;
    }

    public function save(Corredor $e): Corredor
    {
        $m = self::e2m($e);
        $m->save();
        $e->id = $m->id;
        return $e;
    }

    public function findById(int $id): ?Corredor
    {
        $m = M::find($id);
        return self::m2e($m);
    }
}
