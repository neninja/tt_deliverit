<?php

namespace App\Infra\Repositories\Eloquent;

use Core\Models\Prova;
use App\Models\Prova as M;

class ProvasRepository implements \Core\Contracts\Repositories\IProvasRepository
{
    public static function e2m(Prova $e)
    {
        $m = new M();
        if(!is_null($e->id)){
            $m->id = $e->id;
        }
        $m->data = $e->data;
        $m->id_tipoProva = $e->tipo->id;
        $m->data = $e->data;
        return $m;
    }

    public static function m2e(?M $m): ?Prova
    {
        return $m ? new Prova(
            $m->id,
            TiposProvaRepository::m2e($m->tipo),
            date_create_from_format('Y-m-d', $m->data)
        ) : null;
    }

    public function save(Prova $e): Prova
    {
        $m = self::e2m($e);
        $m->save();
        $e->id = $m->id;
        return $e;
    }

    public function findById(int $id): ?Prova
    {
        $m = M::find($id);
        return self::m2e($m);
    }
}
